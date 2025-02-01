<?php

namespace App\Http\Controllers\Student;

use App\Http\Resources\Student\StudentsResource;
use App\Http\Resources\OrderRequestCollection;
use App\Filters\Student\StudentLiteralFilter;
use App\Filters\Student\StudentStatusFilter;
use App\Filters\Student\StudentNameFilter;
use App\Filters\Student\CourseTypeFilter;
use App\Filters\Student\CourseNameFilter;
use Illuminate\Contracts\View\Factory;
use App\Filters\Student\CenterStudent;
use Illuminate\Foundation\Application;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Http\Request;
use App\Models\Students;

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
                CourseTypeFilter::class,
                CourseNameFilter::class,
                CenterStudent::class,
            ])
            ->thenReturn()
            ->with('course')
            ->latest()
            ->orderBy('id', 'desc')
            ->paginate($request->per_page ?? 5);
        $orderRequests = new OrderRequestCollection($students);
        $orderRequests->setResourceClass(StudentsResource::class);
        $filteredStudents = $orderRequests->toArray($request);
        return view('student.students', ['students' => $filteredStudents]);
    }
}
