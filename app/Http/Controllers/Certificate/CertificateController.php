<?php

namespace App\Http\Controllers\Certificate;

use App\Http\Controllers\Result\ResultController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\StudentResult;
use Illuminate\Http\Response;
use App\Models\Students;
use Carbon\Carbon;

class CertificateController extends Controller
{
    /**
     * Default PDF options
     */
    private const PDF_OPTIONS = [
        'defaultFont' => 'sans-serif',
        'isHtml5ParserEnabled' => true,
        'isPhpEnabled' => true,
        'isRemoteEnabled' => true,
        'margin-top' => 0,
        'margin-bottom' => 0,
        'margin-left' => 0,
        'margin-right' => 0,
    ];

    /**
     * @param $studentId
     * @return Response|RedirectResponse
     */
    public function applicationForm($studentId): Response|RedirectResponse
    {
        $student = $this->findStudent($studentId);
        if (!$student) {
            return $this->studentNotFoundResponse();
        }

        $pdf = PDF::loadView('certificate.application-form', ['student' => $student]);
        $pdf->setPaper([0, 0, 800, 1050]);

        return $pdf->download($student->name . '-application-form.pdf');
    }

    /**
     * Generate a migration certificate for a student.
     *
     * @param $studentId
     * @return Response|RedirectResponse|View
     */
    public function migrationForm($studentId): Response|RedirectResponse|View
    {
        return $this->generateCertificate($studentId, 'migration', 'migration-certificate');
    }

    /**
     * Generate a paramedical certificate for a student.
     *
     * @param $studentId
     * @return Response|RedirectResponse|View
     */
    public function paramedicalRegCertificate($studentId): Response|RedirectResponse|View
    {
        return $this->generateCertificate($studentId, 'paramedical-reg-certificate', 'paramedical-registration-certificate');
    }

    /**
     * Generate a certificate for a student.
     *
     * @param $studentId
     * @return Response|RedirectResponse|View
     */
    public function certificate($studentId): Response|RedirectResponse|View
    {
        return $this->generateCertificate($studentId, 'certificate', 'certificate');
    }

    /**
     * Generate a certificate for a student.
     *
     * @param $studentId
     * @return Response|RedirectResponse|View
     */
    public function provisonalCertificate($studentId): Response|RedirectResponse|View
    {
        return $this->generateCertificate($studentId, 'provisonal-certificate', 'provisonal-certificate');
    }

    /**
     * Generate consolidated results for a student.
     *
     * @param $studentId
     * @return Response|RedirectResponse|View
     */
    public function consolidateResult($studentId): Response|RedirectResponse|View
    {
        return $this->generateCertificate($studentId, 'consolidate-result', 'consolidate-result');
    }

    /**
     * Generate result cum for a student.
     *
     * @param $studentId
     * @param $subjectIds
     * @param $duration
     * @return Response|RedirectResponse|View
     */
    public function resultCum($studentId, $subjectIds, $duration): Response|RedirectResponse|View
    {
        return $this->generateCertificate($studentId, 'result-cum', 'result-cum', json_decode($subjectIds, true), $duration);
    }

    /**
     * Generate result cum for a student.
     *
     * @param $key
     * @return Response|RedirectResponse|View
     */
    public function viewStudentResult($key): Response|RedirectResponse|View
    {
        $data = json_decode(base64_decode($key), true);
        if (!$data || !isset($data['student_id'], $data['subject_ids'], $data['duration'])) {
            return redirect()->back()->with('validation_errors', ['Invalid Data Provided.']);
        }

        // Extract values
        $studentId = $data['student_id'];
        $subjectIds = $data['subject_ids'];
        $duration = $data['duration'];

        // Fetch student and results (Example)
        $student = Students::find($studentId);
        if (!$student) {
            return redirect()->back()->with('validation_errors', ['Invalid Data Provided.']);
        }
        return $this->generateCertificate($studentId, 'result-cum', 'result-cum', $subjectIds, $duration, true);
    }

    /**
     * Common logic for generating certificates.
     *
     * @param  $studentId
     * @param  $viewName
     * @param  $certificateType
     * @param null $subjectIds
     * @param null $duration
     * @param bool $isResult
     * @return Response|RedirectResponse|View
     */
    private function generateCertificate($studentId, $viewName, $certificateType, $subjectIds = null, $duration = null, bool $isResult = false): Response|RedirectResponse|View
    {
        $student = $this->findStudent($studentId);
        if (!$student) {
            return $this->studentNotFoundResponse();
        }

        // Calculate course duration and dates
        $courseTotalMonth = $this->calculateCourseDuration($student->course);
        $admissionDate = $this->getAdjustedAdmissionDate($student->admission_date);
        $completionDate = $admissionDate->copy()->addMonths($courseTotalMonth);

        // Prepare data for the certificate
        $data = $this->prepareCertificateData($student, $admissionDate, $completionDate, $certificateType, $subjectIds, $duration);
        if ($isResult) {
            return view('certificate.student-result', ['data' => $data, 'student' => $student]);
        }
        // Generate PDF
        $pdf = PDF::loadView("certificate.$viewName", ['student' => $student, 'data' => $data]);
        $pdf->setPaper([0, 0, 600, 847]);
        $pdf->setOptions(self::PDF_OPTIONS);

        return $pdf->download(strtolower($student->name) . "-$certificateType.pdf");
    }

    /**
     * Find student by ID.
     *
     * @param $studentId
     * @return Students|null
     */
    private function findStudent($studentId): ?Students
    {
        return Students::find($studentId);
    }

    /**
     * Return redirect response when student not found.
     *
     * @return RedirectResponse
     */
    private function studentNotFoundResponse(): RedirectResponse
    {
        return redirect()->back()->with('validation_errors', ['Student not found.']);
    }

    /**
     * Adjust admission date if it's a Sunday.
     *
     * @param string $admissionDate
     * @return Carbon
     */
    private function getAdjustedAdmissionDate(string $admissionDate): Carbon
    {
        $date = Carbon::parse($admissionDate);

        if ($date->isSunday()) {
            $date->addDay(); // Move to the next day (Monday)
        }

        return $date;
    }

    /**
     * Calculate course duration in months.
     *
     * @param $course
     * @return int
     */
    private function calculateCourseDuration($course): int
    {
        return match ($course->type) {
            'year' => $course->duration * 12,
            'semester' => $course->duration * 6,
            default => $course->duration,
        };
    }

    /**
     * Prepare certificate data.
     *
     * @param $student
     * @param $admissionDate
     * @param $completionDate
     * @param $certificateType
     * @param null $subjectIds
     * @param null $duration
     * @return array
     */
    private function prepareCertificateData($student, $admissionDate, $completionDate, $certificateType, $subjectIds = null, $duration = null): array
    {
        $baseUrl = env('LIVE_URL');
        $stream = $student->course->stream;
        $streamName = $stream->name;
        $prefix = $stream->enrollments->first()->prefix->prefix ?? '';
        $prefixParts = explode('/', $prefix);

        // Get division and percentage
        [$division, $percentage] = $this->calculateResults($student);

        // Prepare result data for consolidate-result type
        $resultData = $this->prepareResultData($student, $certificateType, $admissionDate, $subjectIds, $duration);
        $url = '-';
        if ($subjectIds) {
            $key = base64_encode(json_encode([
                'student_id' => $student->id,
                'subject_ids' => $subjectIds,
                'duration' => $duration
            ]));
            $url = route('viewStudentResult', ['key' => $key]); // Get the URL from the named route
        }
        $qrCode = QrCode::format('svg')->size(100)->generate($url);
        $base64Qr = 'data:image/svg+xml;base64,' . base64_encode($qrCode);

        $payload = [
            'stream' => $streamName,
            'division' => $division,
            'percentage' => $percentage,
            'year' => $admissionDate->format('Y'),
            'reg_date' => $completionDate->format('d-M-Y'),
            'para_reg_no' => $prefix . $student->enrollment,
            'year_completion' => $completionDate->format('Y'),
            'completion_year' => $completionDate->format('m-d-Y'),
            'stream_prefix' => $stream->enrollments->first()->name,
            'institute_name' => $this->getInstituteName($streamName),
            'serial_number' => $completionDate->format('Yd') . rand(1000, 9999),
            'footer_date' => $completionDate->copy()->addMonths(2)->format('d-M-Y'),
            'reg_no' => "MIG/REF/{$prefixParts[0]}/" . $completionDate->format('Y') . rand(0, 99),
            'roll_number' => $student->course->prefix->prefix . $student->rollNumbers()->latest('id')->first()?->roll_number,
            'course_name' => $student->course->name,
            'date_of_birth' => Carbon::parse($student->dob)->format('d-M-Y'),
            'certificate_image' => $this->getCertificateImage($baseUrl, $streamName, $certificateType),
            'student_image' => $student['photo'] ? asset($baseUrl . 'storage/' . $student['photo']) : asset($baseUrl . 'assets/img/profileImage.png'),
            'qr_code' => Carbon::parse($student->admission_date)->year > 2013 ? $base64Qr : null,
        ];
        return array_merge($resultData, $payload);
    }

    /**
     * Calculate student's results, division and percentage.
     *
     * @param $student
     * @return array
     */
    private function calculateResults($student): array
    {
        $subjectsWithResults = $student->course->subjects()
            ->with(['subjectResult' => function ($query) use ($student) {
                $query->where('student_id', $student->id);
            }])->get();

        $totalObtainedMarks = 0;
        $totalPracticalObtainedMarks = 0;
        $subjectTotalMarks = 0;

        foreach ($subjectsWithResults as $subject) {
            $subjectResult = $subject->subjectResult?->where('subject_id', $subject->id)
                ->where('student_id', $student->id)->first();

            if ($subjectResult) {
                $totalObtainedMarks += $subjectResult->subject_obtained_marks;
                $totalPracticalObtainedMarks += $subjectResult->practical_obtained_marks;
            }

            $subjectTotalMarks += $subject->max_marks + $subject->practical_max_marks;
        }

        $obtainedMarks = $totalObtainedMarks + $totalPracticalObtainedMarks;
        $percentage = ($subjectTotalMarks > 0) ? ($obtainedMarks / $subjectTotalMarks) * 100 : 0;

        $division = match (true) {
            $percentage > 60 => 'First Division',
            $percentage >= 50 => 'Second Division',
            $percentage >= 40 => 'Third Division',
            default => 'Failed',
        };

        return [$division, $percentage];
    }

    /**
     * Prepare specific result data for certificates.
     *
     * @param $student
     * @param $certificateType
     * @param $admissionDate
     * @param null $subjectIds
     * @param null $duration
     * @return array
     */
    private function prepareResultData($student, $certificateType, $admissionDate, $subjectIds = null, $duration = null): array
    {
        if ($certificateType != 'consolidate-result' && $certificateType != 'result-cum') {
            return [
                'result_session' => '',
                'footer_result_date' => '',
            ];
        }
        if ($subjectIds) {
            $studentResult = StudentResult::where('student_id', $student->id)->whereIn('subject_id', $subjectIds);
            $resultDuration = $student->rollNumbers->where('duration', $duration)->first();
            $resultSession = $resultDuration->session;
            $resultYear = $resultDuration->year;
            $selectedDurationRollNumber = $resultDuration->roll_number;
            preg_match('/\w+ \d{4}$/', $resultDuration->session, $matches);
            $endSession = $matches[0] ?? null;
        } else {
            $studentResult = StudentResult::where('student_id', $student->id);
            $firstDurationSession = $student->rollNumbers->first()->session;
            $lastDurationSession = $student->rollNumbers->last();
            preg_match('/^\w+ \d{4}/', $firstDurationSession, $matches);
            $startSession = $matches[0] ?? null;
            preg_match('/\w+ \d{4}$/', $lastDurationSession->session, $matches);
            $endSession = $matches[0] ?? null;
            $resultSession = $startSession . '-' . $endSession;
            $resultYear = $lastDurationSession->year;
            $selectedDurationRollNumber = $lastDurationSession->roll_number;
        }
        $date = Carbon::createFromFormat('M Y', $endSession);

        $exactFooterYear = $date->addMonth()->format('M-Y');
        $resultFooter = $admissionDate->addMonth()->format('m-') . $exactFooterYear;
        $finalResult = ResultController::resultCalculation($student, $studentResult);


        return array_merge($finalResult, [
            'result_session' => $resultSession,
            'footer_result_date' => $resultFooter,
            'result_serail_number' => $resultYear . $admissionDate->format('m') . rand(1000, 9999),
            'result_cum_roll_number' => $student->course->prefix->prefix . ($selectedDurationRollNumber ?? ''),
        ]);
    }

    /**
     * Get the institute name based on the stream.
     *
     * @param string $streamName
     * @return string
     */
    private function getInstituteName(string $streamName): string
    {
        return match ($streamName) {
            'ITI' => 'SWAMI VIVEKANAND INDUSTRIAL & VOCATIONAL TRAINING INSTITUTE , SOHNA',
            'TECHNOLOGY & MGMT' => 'SWAMI VIVEKANAND INSTITUTE OF TECHNOLOGY & MANAGEMENT , SOHNA',
            default => 'SWAMI VIVEKANAND INSTITUTE OF PARAMEDICAL SCIENCE , SOHNA',
        };
    }

    /**
     * Get the correct certificate image path.
     *
     * @param string $baseUrl
     * @param string $streamName
     * @param string $certificateType
     * @return string
     */
    private function getCertificateImage(string $baseUrl, string $streamName, string $certificateType): string
    {
        $streamFolder = match ($streamName) {
            'ITI' => 'iti',
            'TECHNOLOGY & MGMT' => 'technology',
            default => 'paramedical',
        };

        $certificateFile = match ($certificateType) {
            'migration-certificate' => 'migration',
            'certificate' => 'certificate',
            'consolidate-result' => 'consolidate',
            'result-cum' => 'result-cum',
            'provisonal-certificate' => 'provisonal-certificate',
            default => 'paramedical-registration-certificate',
        };

        // Special case for paramedical registration certificate
        if ($certificateType === 'paramedical-registration-certificate') {
            return $baseUrl . 'assets/img/certificates/paramedical/paramedical-registration-certificate.png';
        }

        return $baseUrl . "assets/img/certificates/{$streamFolder}/{$streamFolder}-{$certificateFile}.png";
    }
}
