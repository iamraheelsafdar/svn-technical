<?php

namespace App\Http\Controllers\Result;

use App\Http\Controllers\Certificate\CertificateController;
use App\Http\Requests\Result\AutoResultCreationRequest;
use App\Http\Requests\Result\CreateResultRequest;
use App\Models\Prefix;
use App\Models\StudentRollNumber;
use App\Models\Subject;
use App\Models\SvnStream;
use Illuminate\Console\View\Components\Factory;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Console\Application;
use Illuminate\Contracts\View\View;
use App\Models\StudentResult;
use App\Models\Students;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        if (!$studentResult->exists()) {
            return redirect()->back()->with('validation_errors', ['Student reult not found.']);
        }
        $finalResult = self::resultCalculation($student, $studentResult);
        return view('result.view-result', ['result' => $finalResult]);
    }

    public static function resultCalculation($student, $studentResult): array
    {
        $allSubjects = $student->course->subjects->whereIn('id', $studentResult->pluck('subject_id')->toArray())->sortBy('duration_part');
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
                'digit_duration' => $duration,
                'ids' => $subjects->pluck('id')->toArray(),
                'duration' => ucfirst($student->course->type) . ' ' . $duration, // e.g., "Year 1" or "Semester 1"
                'roll_number' => $student->course->prefix->prefix . $student->rollNumbers->where('duration', $duration)->first()?->roll_number, // e.g., "Year 1" or "Semester 1"
            ];

            foreach ($subjects as $subject) {
                $subjectResult = $subject->subjectResult->where('subject_id', $subject->id)->where('student_id', $student->id)->first(); // Assuming one result per subject per student
                $durationResults['subjects'][] = [
                    'id' => $subject->id,
                    'subject_name' => $subject->name,
                    'subject_max_marks' => $subject->max_marks + $subject->practical_max_marks,
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

        // Get all subjects for this course
        if ($student->lateral_entry){
            $subjects = $student->course->subjects->where('duration_part', '>' ,$student->lateral_duration);
        } else {
            $subjects = $student->course->subjects;
        }

        // Create an empty array to store results
        $results = [];

        // Process each subject individually with realistic variation
        foreach ($subjects as $subject) {
            // Calculate base target percentage with some randomization
            // This creates variation between subjects while maintaining the overall target percentage
            $subjectPercentage = $this->getRandomizedPercentage($resultPercentage);

            // Calculate theory marks with the randomized percentage
            $theoreticalMarks = ceil(($subject->max_marks * $subjectPercentage) / 100);

            // Ensure theory marks are at least the minimum required (with some buffer above minimum)
            $theoryMinimum = $subject->min_marks;
            $theoryObtained = max($theoreticalMarks, $theoryMinimum + random_int(1, 5));

            // Ensure we don't exceed maximum marks
            $theoryObtained = min($theoryObtained, $subject->max_marks);

            // Calculate practical marks if applicable
            $practicalObtained = null;
            if ($subject->practical_max_marks > 0) {
                // Use a slightly different percentage for practical to add more variation
                $practicalPercentage = $this->getRandomizedPercentage($resultPercentage);

                $practicalMarks = ceil(($subject->practical_max_marks * $practicalPercentage) / 100);

                // Ensure practical marks are at least the minimum required
                $practicalMinimum = $subject->practical_min_marks;
                $practicalObtained = max($practicalMarks, $practicalMinimum + random_int(1, 3));

                // Ensure we don't exceed maximum practical marks
                $practicalObtained = min($practicalObtained, $subject->practical_max_marks);
            }

            // Store the calculated marks
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

    /**
     * Generate a randomized percentage around the target percentage
     * This creates realistic variation between subjects
     */
    private function getRandomizedPercentage(float $targetPercentage): float
    {
        // Determine variation range based on target percentage
        // Higher target percentages have less variation, lower have more
        $variationRange = match(true) {
            $targetPercentage >= 90 => 8,  // 90-100% scores vary by ±8%
            $targetPercentage >= 80 => 10, // 80-89% scores vary by ±10%
            $targetPercentage >= 70 => 12, // 70-79% scores vary by ±12%
            default => 15,                 // Below 70% can vary by ±15%
        };

        // Generate random variation within the range
        $variation = random_int(-$variationRange, $variationRange);

        // Apply variation to target percentage
        $adjustedPercentage = $targetPercentage + $variation;

        // Ensure the result stays within reasonable bounds (50-100%)
        return max(50, min(100, $adjustedPercentage));
    }


    public function getStudentResult(Request $request)
    {
        $parts = explode('/', $request['roll_number']);

        $firstPart = $parts[0] . '/' . $parts[1] . '/';
        $secondPart = $parts[2] . '/' . $parts[3] . '/' . $parts[4];

        $formattedDate = Carbon::createFromFormat('d/m/Y', $request['dob'])->format('Y-m-d');
        $studentRollNumber = StudentRollNumber::where('roll_number', $secondPart)->first();
        $checkPrefixes = Prefix::where('prefix' , $firstPart)->first();

        if ($studentRollNumber && $checkPrefixes) {
            $student = Students::where([['dob', $formattedDate], ['id', $studentRollNumber->student_id], ['status', 1]])->first();
            if (!$student) {
                return response()->json(['error' => 'Result not found'], 404);
            }
            $courseSteam = SvnStream::whereIn('name', $request['steam_name'])->where('id', $student->course?->stream_id)->first();
            $subjectIds = Subject::where('course_id' , $student->course->id)->where('duration_part',$studentRollNumber->duration)->pluck('id')->toArray();
            if ($courseSteam) {
                $studentResults = StudentResult::where('student_id', $student['id'])->whereIn('subject_id',$subjectIds)->get();
                if (count($studentResults) > 0) {
                    $studentDetail = [];
                    foreach ($studentResults as $studentResult) {
                        $studentDetail[] = [
                            'subject_name' => $studentResult->subject->name,
                            'total_marks' => $studentResult->subject->max_marks + ($studentResult->subject->practical_max_marks ?? 0) ,
                            'theory_marks' => $studentResult->subject_obtained_marks,
                            'practical_marks' => $studentResult->practical_obtained_marks,
                            'obtained_marks' => $studentResult->subject_obtained_marks + $studentResult->practical_obtained_marks,
                        ];
                    }

                    $studentData = [
                        'student_name' => $student['name'],
                        'father_name' => $student['father_name'],
                        'mother_name' => $student['mother_name'],
                        'dob' => Carbon::parse($student['dob'])->format('d-m-Y'),
                        'enrolment_no_start' => $student->course->stream?->enrollments->first()?->prefix->prefix . $student->enrollment,
                        'roll_number' => $request['roll_number'],
                        'session' => $studentRollNumber->year,
                        'mobile_number' => '-',
                        'course_name' => $student->course->name . ($student['laterl_entry'] ? ' (LE) ' : ''),
                        'institute' => CertificateController::getInstituteName($student->course->stream->name, $student),
                        'student_image' => env('LIVE_URL').'storage/' . $student->photo,
                        'type' => strtoupper($student->course->type) . '-' . $studentRollNumber->duration,
                    ];

                    if ($studentRollNumber->duration == $student->course->duration) {

                    $summery = [];
                    $allSubjectIds = []; // <-- collect relevant subject IDs only

                    for ($i = 1; $i <= $studentRollNumber->duration; $i++) {
                        $durationPart = $student->lateral_duration + $i;

                        $subjectIdValid = Subject::where('course_id', $student->course->id)
                            ->where('duration_part', $durationPart)
                            ->pluck('id')
                            ->toArray();

                        // Merge subject IDs into master list
                        $allSubjectIds = array_merge($allSubjectIds, $subjectIdValid);

                        $periodResults = StudentResult::where('student_id', $student['id'])
                            ->whereIn('subject_id', $subjectIdValid)
                            ->get();

                        if ($periodResults->count() > 0) {
                            $periodObtained = $periodResults->sum(function ($result) {
                                return $result->subject_obtained_marks + ($result->practical_obtained_marks ?: 0);
                            });

                            $periodMax = $periodResults->sum(function ($result) {
                                return $result->subject->max_marks + ($result->subject->practical_max_marks ?: 0);
                            });

                            if ($periodMax > 0) {
                                $summery[] = [
                                    'year' => strtoupper($student->course->type) . '-' . $durationPart,
                                    'marks' => $periodObtained . '/' . $periodMax
                                ];
                            }
                        }
                    }

                    // Filter all results by relevant subject IDs only
                    $filteredResults = StudentResult::where('student_id', $student['id'])
                        ->whereIn('subject_id', $allSubjectIds)
                        ->get();

                    $totalObtained = $filteredResults->sum(function ($result) {
                        return $result->subject_obtained_marks + ($result->practical_obtained_marks ?: 0);
                    });

                    $totalMax = $filteredResults->sum(function ($result) {
                        return $result->subject->max_marks + ($result->subject->practical_max_marks ?: 0);
                    });

                    $summery[] = [
                        'total_marks' => $totalObtained . '/' . $totalMax,
                    ];

                    $response['summery'] = $summery;
                    }
                    $response['student_detail'] = $studentData;
                    $response['student_result'] = $studentDetail;

                    return response()->json($response, 200);
                }
                return response()->json(['error' => 'Result not found'], 404);
            }
            return response()->json(['error' => 'Result not found'], 404);

        }
        return response()->json(['error' => 'Result not found'], 404);
    }
}
