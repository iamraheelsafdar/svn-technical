<?php

namespace App\Http\Controllers\Result;

use App\Http\Requests\Result\AutoResultCreationRequest;
use App\Http\Requests\Result\CreateResultRequest;
use Illuminate\Console\View\Components\Factory;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Console\Application;
use Illuminate\Contracts\View\View;
use App\Models\StudentResult;
use App\Models\Students;
use App\Models\Course;
use Carbon\Carbon;

class ResultController extends Controller
{
    /**
     * @param $studentId
     * @return Application|Factory|View|RedirectResponse
     */
    public function createResultView($studentId): Application|Factory|View|RedirectResponse
    {
        $student = Students::where('status', 1)->find($studentId);
        if (!$student) {
            return redirect()->back()->with('validation_errors', ['Student not found.']);
        }
        $course = Course::where('status', 1)->find($student->course_id);
        if (!$course) {
            return redirect()->back()->with('validation_errors', ['Course not found.']);
        }
        return view('result.create-result', ['course' => $course, 'student' => $student, 'result' => $student->result->where('student_id', $studentId)]);
    }

    /**
     * @param CreateResultRequest $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function createResult(CreateResultRequest $request): Application|Factory|View|RedirectResponse
    {
        $student = Students::find($request->student_id);
        if (!$student) {
            return redirect()->back()->with('validation_errors', ['Student not found.']);
        }

        $subjectsData = $request->input('subjects');
        $updatedAt = null;
        // Loop through the grouped subjects by duration (year/semester)
        foreach ($subjectsData as $duration => $subjects) {
            // Loop through each subject in the duration
            foreach ($subjects as $subjectData) {
                $updatedAt = $subjectData['subject_id'] ?? null;
                StudentResult::updateOrCreate(
                    ['id' => $subjectData['subject_id'] ?? null], // Condition to find existing record
                    [
                        'student_id' => $student->id,
                        'subject_id' => $subjectData['id'],
                        'subject_obtained_marks' => $subjectData['obtained_marks'],
                        'practical_obtained_marks' => $subjectData['practical_obtained_marks'],
                    ]
                );
            }
        }
        session()->flash('success', 'Result ' . ($updatedAt !== null ? 'updated' : 'created') . ' successfully for ' . $student->name . '.');
        return redirect()->route('studentsView');
    }

    /**
     * @param $studentId
     * @return Application|Factory|View|RedirectResponse
     */
    public function viewResult($studentId): Application|Factory|View|RedirectResponse
    {
        $student = Students::find($studentId);
        if (!$student) {
            return redirect()->back()->with('validation_errors', ['Student not found.']);
        }
        $studentResult = StudentResult::where('student_id', $student->id);
        if (!$studentResult->exists()){
            return redirect()->back()->with('validation_errors', ['Student reult not found.']);
        }
        $finalResult = self::resultCalculation($student, $studentResult);
        return view('result.view-result', ['result' => $finalResult]);
    }

    public static function resultCalculation($student, $studentResult): array
    {
        $allSubjects = $student->course->subjects->whereIn('id',$studentResult->pluck('subject_id')->toArray())->sortBy('duration_part');
        $finalResult = [
            'results' => [], // Initialize an array to store grouped results by duration
            'student_id' => $student->id,
            'student_name' => $student->name,
            'lateral' => $student->lateral_entry,
            'mother_name' => $student->mother_name,
            'father_name' => $student->father_name,
            'course_name' => $student->course->name,
            'dob' => Carbon::parse($student->dob)->format('d-M-Y'),
            'enrollment' => ($student->course->stream->enrollments->first()->prefix->prefix ?? '') . $student->enrollment,
        ];

        // Group subjects by duration_part
        foreach ($allSubjects->groupBy('duration_part') as $duration => $subjects) {
            $durationResults = [
                'subjects' => [], // Initialize an array to store subject results for this duration
                'duration' => ucfirst($student->course->type) . ' ' . $duration, // e.g., "Year 1" or "Semester 1"
                'roll_number' => $student->course->prefix->prefix . $student->rollNumbers->where('duration' , $duration)->first()?->roll_number, // e.g., "Year 1" or "Semester 1"
            ];

            foreach ($subjects as $subject) {
                $subjectResult = $subject->subjectResult->where('subject_id', $subject->id)->where('student_id',$student->id)->first(); // Assuming one result per subject per student
                $durationResults['subjects'][] = [
                    'id' => $subject->id,
                    'subject_name' => $subject->name,
                    'subject_max_marks' => $subject->max_marks,
                    'subject_obtained_marks' => $subjectResult ? $subjectResult->subject_obtained_marks : '--',
                    'total_marks' => $subjectResult ? ($subjectResult->subject_obtained_marks + $subjectResult->practical_obtained_marks) : '--',
                    'practical_obtained_marks' => $subjectResult ? ($subjectResult->practical_obtained_marks == 0 ? '--' : $subjectResult->practical_obtained_marks) : '--',
                ];
            }

            $finalResult['results'][] = $durationResults; // Add duration-specific results to the final result
        }
        return $finalResult;
    }


    public function autoResultCreation(AutoResultCreationRequest $request): RedirectResponse
    {
        $student = Students::findOrFail($request->student_id);

        if ($student->result()->exists()) {
            session()->flash('validation_errors', ['Student result already exists.']);
            return redirect()->route('studentsView');
        }

        $resultPercentage = max(60, min(100, $request->result_percentage)); // Ensure within 60-100 range

        // Calculate total max marks
        $totalMaxTheoryMarks = $student->course->subjects->sum('max_marks');
        $totalMaxPracticalMarks = $student->course->subjects->sum('practical_max_marks');

        // Calculate total obtained marks for both theory and practical
        $totalObtainedTheoryMarks = ceil(($totalMaxTheoryMarks * $resultPercentage) / 100);
        $totalObtainedPracticalMarks = ceil(($totalMaxPracticalMarks * $resultPercentage) / 100);

        // Distribute the obtained marks proportionally among subjects
        foreach ($student->course->subjects as $subject) {
            // Calculate proportionate marks for each subject
            $theoryObtained = ceil(($subject->max_marks / $totalMaxTheoryMarks) * $totalObtainedTheoryMarks);
            $practicalObtained = ($subject->practical_max_marks > 0)
                ? ceil(($subject->practical_max_marks / $totalMaxPracticalMarks) * $totalObtainedPracticalMarks)
                : null;

            // Ensure obtained marks are not lower than min required
            $theoryObtained = max($theoryObtained, $subject->min_marks + random_int(0, 2));
            if ($practicalObtained !== null) {
                $practicalObtained = max($practicalObtained, $subject->practical_min_marks + random_int(0, 2));
            }

            // Insert result into student_result table
            StudentResult::create([
                'student_id' => $student->id,
                'subject_id' => $subject->id,
                'subject_obtained_marks' => $theoryObtained,
                'practical_obtained_marks' => $practicalObtained,
            ]);
        }

        session()->flash('success', 'Result created successfully for ' . $student->name . '.');
        return redirect()->route('studentsView');
    }
}
