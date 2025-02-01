<?php

namespace App\Http\Controllers\Course;

use App\Http\Requests\Course\CheckCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Requests\Course\AddCourseRequest;
use App\Filters\Course\CourseEnrollmentFilter;
use App\Http\Resources\OrderRequestCollection;
use App\Http\Resources\Course\CourseResource;
use App\Filters\Course\CourseCreatedFilter;
use App\Filters\Course\CourseStatusFilter;
use App\Filters\Course\CourseStreamFilter;
use App\Filters\Course\CourseNameFilter;
use App\Filters\Course\CourseTypeFilter;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\SvnStream;
use App\Models\Prefix;
use App\Models\Course;

class CourseController extends Controller
{

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function courses(Request $request): Factory|View|Application
    {
        $enrollments = app(Pipeline::class)
            ->send(Course::query())
            ->through([
                CourseNameFilter::class,
                CourseStreamFilter::class,
                CourseEnrollmentFilter::class,
                CourseTypeFilter::class,
                CourseStatusFilter::class,
                CourseCreatedFilter::class
            ])
            ->thenReturn()
            ->with('stream.enrollments', 'subjects')
            ->latest()
            ->orderBy('id', 'desc')
            ->paginate($request->per_page ?? 5);

        $orderRequests = new OrderRequestCollection($enrollments);
        $orderRequests->setResourceClass(CourseResource::class);
        $filteredCourses = $orderRequests->toArray($request);
        return view('course.courses', ['courses' => $filteredCourses]);
    }

    /**
     * @return Factory|View|Application
     */
    public function addCourseView(): Factory|View|Application
    {
        $streams = SvnStream::where('status', 1)
            ->with(['enrollments' => function ($query) {
                $query->where('status', 1)->select('id', 'name', 'stream_id'); // Fetch specific columns
            }])
            ->get()
            ->map(function ($stream) {
                return [
                    'stream_id' => $stream->id,
                    'stream_name' => $stream->name,
                    'enrollments' => $stream->enrollments->map(function ($enrollment) {
                        return [
                            'enrollment_id' => $enrollment->id,
                            'enrollment_name' => $enrollment->name,
                        ];
                    })->toArray(),
                ];
            })
            ->toArray();
        $coursePrefixes = Prefix::where([['prefix_assign_to', 'Course Management'], ['status', 1]])->pluck('id', 'prefix')->toArray();
        $courseDetails = ['streams' => $streams, 'coursePrefixes' => $coursePrefixes];
        return view('course.add-course', ['courseDetails' => $courseDetails]);
    }

    /**
     * @param AddCourseRequest $request
     * @return RedirectResponse
     */
    public function addCourse(AddCourseRequest $request): RedirectResponse
    {
        Course::create([
            'stream_id' => $request->stream_name,
            'prefix_id' => $request->roll_number_prefix,
            'name' => $request->course_name,
            'code' => $request->course_code,
            'type' => $request->course_type,
            'duration' => $request->duration,
        ]);
        session()->flash('success', 'Course added successfully');
        return redirect()->route('coursesPage');
    }


    public function updateCourseStatus(CheckCourseRequest $request): JsonResponse
    {
        $prefix = Course::find($request->id);
        $prefix->update(['status' => (bool)$request->status]);
        return response()->json([
            'header_code' => 200,
            'message' => 'Course status updated successfully.',
        ]);
    }

    public function updateCourseView($id): Application|View|Factory|RedirectResponse
    {
        $course = Course::find($id);
        if (!$course) {
            return redirect()->back()->with('validation_errors', ['Course not found.']);
        }
        $streams = SvnStream::where('status', 1)
            ->with(['enrollments' => function ($query) {
                $query->where('status', 1)->select('id', 'name', 'stream_id'); // Fetch specific columns
            }])
            ->get()
            ->map(function ($stream) {
                return [
                    'stream_id' => $stream->id,
                    'stream_name' => $stream->name,
                    'enrollments' => $stream->enrollments->map(function ($enrollment) {
                        return [
                            'enrollment_id' => $enrollment->id,
                            'enrollment_name' => $enrollment->name,
                        ];
                    })->toArray(),
                ];
            })
            ->toArray();
        $coursePrefixes = Prefix::where([['prefix_assign_to', 'Course Management'], ['status', 1]])->pluck('id', 'prefix')->toArray();
        $courseDetails = ['streams' => $streams, 'coursePrefixes' => $coursePrefixes];
        return view('course.update-course', ['course' => $course, 'courseDetails' => $courseDetails]);
    }

    public function updateCourse(UpdateCourseRequest $request): RedirectResponse
    {
        $course = Course::find($request->id);
        $course->update([
            'stream_id' => $request->stream_name,
            'prefix_id' => $request->roll_number_prefix,
            'name' => $request->course_name,
            'code' => $request->course_code,
            'type' => $request->course_type,
            'duration' => $request->duration,
        ]);
        session()->flash('success', 'Course updated successfully');
        return redirect()->route('coursesPage');
    }
}
