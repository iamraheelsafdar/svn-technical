<?php

namespace App\Http\Controllers\Result;

use App\Http\Requests\Result\CreateResultRequest;
use Illuminate\Console\View\Components\Factory;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Console\Application;
use Illuminate\Contracts\View\View;
use App\Models\StudentResult;
use App\Models\Students;
use App\Models\Course;

class ResultController extends Controller
{
    public function createResultView($id, $studentId): Application|Factory|View|RedirectResponse
    {
        $course = Course::where('status', 1)->find($id);
        if (!$course) {
            return redirect()->back()->with('validation_errors', ['Course not found.']);
        }
        $student = Students::where('status', 1)->find($studentId);
        if (!$student) {
            return redirect()->back()->with('validation_errors', ['Student not found.']);
        }
        return view('result.create-result', ['course' => $course, 'student' => $student, 'result' => $student->result]);
    }

    public function createResult(CreateResultRequest $request): Application|Factory|View|RedirectResponse
    {
        $student = Students::find($request->student_id);
        if (!$student) {
            return redirect()->back()->with('validation_errors', ['Student not found.']);
        }

        $subjectsData = $request->input('subjects');

        // Loop through the grouped subjects by duration (year/semester)
        foreach ($subjectsData as $duration => $subjects) {
            // Loop through each subject in the duration
            foreach ($subjects as $subjectData) {
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
        session()->flash('success', "Result created successfully of {$student->name}.");
        return redirect()->route('studentsView');
    }
}
