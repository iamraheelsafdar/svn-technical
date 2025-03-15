<?php

namespace App\Http\Controllers\Student;

use App\Http\Requests\Student\UpdateStudentRequest;
use App\Http\Requests\Student\AddStudentRequest;
use App\Http\Resources\Student\StudentsResource;
use App\Http\Resources\OrderRequestCollection;
use App\Filters\Student\StudentLiteralFilter;
use App\Filters\Student\StudentStatusFilter;
use App\Filters\Student\StudentNameFilter;
use App\Filters\Student\StreamNameFilter;
use App\Filters\Student\CourseTypeFilter;
use App\Filters\Student\CourseNameFilter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\Factory;
use App\Filters\Student\CenterStudent;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Pipeline\Pipeline;
use App\Models\StudentRollNumber;
use App\Models\StudentReference;
use Illuminate\Http\Request;
use App\Models\SvnStream;
use App\Models\Students;
use App\Models\Prefix;
use App\Models\Course;
use Carbon\Carbon;

class StudentController extends Controller
{
    /**
     * @param Request $request
     * @return Factory|Application|View
     */
    public function students(Request $request): Factory|Application|View
    {
        $students = app(Pipeline::class)
            ->send(Students::query())
            ->through([
                StudentLiteralFilter::class,
                StudentStatusFilter::class,
                StudentNameFilter::class,
                StreamNameFilter::class,
                CourseTypeFilter::class,
                CourseNameFilter::class,
                CenterStudent::class,
            ])
            ->thenReturn()
            ->with(['course.stream'])
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate($request->input('per_page', 5));
        $orderRequests = new OrderRequestCollection($students);
        $orderRequests->setResourceClass(StudentsResource::class);
        $filteredStudents = $orderRequests->toArray($request);
        $filteredStudents['all_stream'] = SvnStream::pluck('name')->toArray();
        $filteredStudents['courses'] = Course::distinct('name')->pluck('name')->unique()->toArray();
        return view('student.students', ['students' => $filteredStudents]);
    }

    /**
     * Helper method to fetch streams with courses
     * @return mixed
     */
    private function getStreamsWithCourses(): mixed
    {
        return SvnStream::where('status', 1)
            ->with(['courses' => function ($query) {
                $query->where('status', 1)->select('id', 'name', 'stream_id', 'duration', 'type');
            }])->get()->map(function ($stream) {
                return [
                    'stream_id' => $stream->id,
                    'stream_name' => $stream->name,
                    'courses' => $stream->courses->map(function ($course) {
                        return [
                            'course_id' => $course->id,
                            'course_name' => $course->name . ', ' . $course->duration . '-' . ucfirst($course->type),
                            'course_duration' => $course->duration,
                            'course_type' => ucfirst($course->type)
                        ];
                    })->toArray(),
                ];
            })->toArray();
    }

    /**
     * Show the student add view
     * @param Request $request
     * @return Factory|Application|View
     */
    public function addStudentView(Request $request): Factory|Application|View
    {
        $streams = $this->getStreamsWithCourses();
        $coursePrefixes = Prefix::where([['prefix_assign_to', 'Course Management'], ['status', 1]])
            ->pluck('id', 'prefix')
            ->toArray();

        $courseDetails = ['streams' => $streams, 'coursePrefixes' => $coursePrefixes];
        return view('student.add-student', ['courseDetails' => $courseDetails]);
    }

    /**
     * Handle the student registration
     * @param AddStudentRequest $request
     * @return RedirectResponse
     */
    public function addStudent(AddStudentRequest $request): RedirectResponse
    {
        $allStudents = Students::count();
        // Handle file uploads using a loop for better scalability and readability
        $files = ['student_image', 'student_qualification', 'student_id', 'student_signature'];
        $uploadedFiles = [];

        foreach ($files as $file) {
            if ($request->hasFile($file)) {
                $uploadedFiles[$file] = Storage::disk('public')->put('students/', $request->file($file));
            }
        }

        // Create the student record
        $student = Students::create([
            'mode' => $request->mode,
            'state' => $request->state,
            'course_id' => $request->course,
            'name' => $request->student_name,
            'center_id' => auth()->user()->id,
            'gender' => ucfirst($request->gender),
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'photo' => $uploadedFiles['student_image'] ?? null,
            'lateral_entry' => $request->lateral == '1' ? 1 : 0,
            'identity_card' => $uploadedFiles['student_id'] ?? null,
            'signature' => $uploadedFiles['student_signature'] ?? null,
            'registration_date' => Carbon::now()->format('Y-m-d'),
            'qualification' => $uploadedFiles['student_qualification'] ?? null,
            'lateral_duration' => $request->lateral == '1' ? $request->lateral_duration : 0,
            'dob' => Carbon::createFromFormat('d-m-Y', $request->dob)->format('Y-m-d'),
            'admission_date' => Carbon::createFromFormat('d-m-Y', $request->admission_date)->format('Y-m-d'),
            'enrollment' => Carbon::createFromFormat('d-m-Y', $request->admission_date)->format('dmY') . '/' . ($allStudents + 1),
        ]);
        $course = $student->course;
        $skipLateral = $request->input('lateral_duration', 0);

        // Convert admission_date back to Carbon instance
        $admissionDate = Carbon::parse($student->admission_date);

        for ($i = 1; $i <= ($course->duration - $skipLateral); $i++) {

            if ($course->type == 'year') {
                $rollWithDate = $admissionDate->copy()->addYears($i)->format('Y');
            } elseif ($course->type == 'semester') {
                $rollWithDate = $admissionDate->copy()->addMonths(6 * $i)->format('Y');
            } else {
                $rollWithDate = $admissionDate->copy()->addMonths($course->duration * $i)->format('Y');
            }
            StudentRollNumber::create([
                'student_id' => $student->id,
                'roll_number' => $rollWithDate . '/' . rand(99, 999) . '/' . rand(1, 1000)
            ]);
        }
        session()->flash('success', 'Student registered successfully.');
        return redirect()->route('studentsView');

    }

    /**
     * Show the student update view
     * @param $id
     * @return Application|View|Factory|RedirectResponse
     */
    public function updateStudentView($id): Application|View|Factory|RedirectResponse
    {
        $student = Students::find($id);

        if (!$student) {
            return redirect()->back()->with('validation_errors', ['Student not found.']);
        }

        $streams = $this->getStreamsWithCourses();
        $student->dob = Carbon::parse($student->dob)->format('d-m-Y');
        $student->admission_date = Carbon::parse($student->admission_date)->format('d-m-Y');
        $studentReference = StudentReference::where('status', 1)->get();
        $coursePrefixes = Prefix::where([['prefix_assign_to', 'Course Management'], ['status', 1]])
            ->pluck('id', 'prefix')
            ->toArray();

        $courseDetails = ['streams' => $streams, 'coursePrefixes' => $coursePrefixes];
        return view('student.update-student', ['student' => $student, 'courseDetails' => $courseDetails, 'references' => $studentReference]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateStudentStatus(Request $request): JsonResponse
    {
        $prefix = Students::find($request->id);
        $prefix->update(['status' => (bool)$request->status]);
        return response()->json([
            'header_code' => 200,
            'message' => 'Student status updated successfully.',
        ]);
    }

    /**
     * @param UpdateStudentRequest $request
     * @return RedirectResponse
     */
    public function updateStudent(UpdateStudentRequest $request): RedirectResponse
    {
        $student = Students::where('id', $request->student_id)->first();
        $student->update([
            'mode' => $request->mode,
            'name' => $request->student_name,
            'gender' => ucfirst($request->gender),
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'reference_id' => $request->reference_id,
        ]);

        $files = ['student_image', 'student_qualification', 'student_id', 'student_signature'];
        $uploadedFiles = [];

        foreach ($files as $file) {
            if ($request->hasFile($file)) {
                $uploadedFiles[$file] = Storage::disk('public')->put('students/', $request->file($file));
            }
        }

        if ($request->hasFile('student_image')) {
            $student->update(['photo' => $uploadedFiles['student_image']]);
        }
        if ($request->hasFile('student_signature')) {
            $student->update(['signature' => $uploadedFiles['student_signature']]);
        }
        if ($request->hasFile('student_qualification')) {
            $student->update(['qualification' => $uploadedFiles['student_qualification']]);
        }
        if ($request->hasFile('student_id')) {
            $student->update(['identity_card' => $uploadedFiles['student_id']]);
        }

        session()->flash('success', 'Student updated successfully.');
        return redirect()->route('studentsView');
    }
}
