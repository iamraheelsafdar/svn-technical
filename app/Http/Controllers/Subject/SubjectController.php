<?php

namespace App\Http\Controllers\Subject;

use App\Http\Requests\Subject\UpdateSubjectRequest;
use App\Http\Requests\Subject\AddSubjectRequest;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use App\Models\Subject;
use App\Models\Course;

class SubjectController extends Controller
{
    /**
     * @param $id
     * @return Factory|View|Application|RedirectResponse
     */
    public function addSubjectView($id): Factory|Application|View|RedirectResponse
    {
        $course = Course::find($id);
        if (!$course) {
            return redirect()->back()->with('validation_errors', ['Center not found.']);
        }
        return view('subject.add-subject', ['course' => $course]);
    }

    /**
     * @param AddSubjectRequest $request
     * @return RedirectResponse
     */
    public function addSubject(AddSubjectRequest $request): RedirectResponse
    {
        $course = Course::find($request->course_id);
        if (!$course) {
            return redirect()->back()->with('validation_errors', ['Course not found.']);
        }

        $subjectsData = $request->input('subjects');

        // Loop through each set of subjects (e.g., 1st duration, 2nd duration)
        foreach ($subjectsData as $duration => $subjects) {
            $subjectCount = count($subjects['name']);
            for ($index = 0; $index < $subjectCount; $index++) {
                // Prepare and save each subject
                Subject::create([
                    'course_id' => $request->course_id,
                    'duration_part' => $duration,
                    'name' => $subjects['name'][$index],
                    'code' => $subjects['code'][$index],
                    'min_marks' => $subjects['min_marks'][$index],
                    'max_marks' => $subjects['max_marks'][$index],
                    'is_practical' => $subjects['is_practical'][$index] == 'true' ? 1 : 0,
                    'practical_min_marks' => $subjects['practical_min_marks'][$index] ?? null,
                    'practical_max_marks' => $subjects['practical_max_marks'][$index] ?? null,
                ]);
            }
        }

        session()->flash('success', 'Subjects added successfully.');
        return redirect()->route('coursesPage');
    }

    public function updateSubjectView($id): Application|View|Factory|RedirectResponse
    {
        $course = Course::with('subjects')->find($id);
        if (!$course) {
            return redirect()->back()->with('validation_errors', ['Subject not found.']);
        }
        return view('subject.update-subject', ['course' => $course]);
    }

    public function updateSubjects(UpdateSubjectRequest $request): RedirectResponse
    {
        $subjectsData = $request->input('subjects');
        // Loop through the grouped subjects by duration (year/semester)
        foreach ($subjectsData as $duration => $subjects) {
            // Loop through each subject in the duration
            foreach ($subjects as $subjectData) {
                // Update each subject based on the subject ID
                Subject::where('id', $subjectData['id'])->where('course_id', $request->course_id)->update([
                    'name' => $subjectData['name'],
                    'code' => $subjectData['code'],
                    'min_marks' => $subjectData['min_marks'],
                    'max_marks' => $subjectData['max_marks'],
                    'is_practical' => $subjectData['is_practical'] == 'true' ? 1 : 0,
                    'practical_min_marks' => $subjectData['practical_min_marks'] ?? null,
                    'practical_max_marks' => $subjectData['practical_max_marks'] ?? null,
                ]);
            }
        }

        session()->flash('success', 'Subjects updated successfully.');
        return redirect()->route('coursesPage');

    }
}
