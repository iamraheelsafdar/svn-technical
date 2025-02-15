<?php

namespace App\Http\Controllers\Certificate;

use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\View\Factory;
use Illuminate\Http\Request;
use App\Models\Students;
use Carbon\Carbon;
use DateInterval;

class CertificateController extends Controller
{
    /**
     * @param $id
     * @return Response|RedirectResponse
     */
    public function applicationForm($id): Response|RedirectResponse
    {
        $student = Students::find($id);
        if (!$student) {
            return redirect()->back()->with('validation_errors', ['Student not found.']);
        }
        // Load the Blade view
        $pdf = PDF::loadView('certificate.application-form', ['student' => $student]);
        $pdf->setPaper([0, 0, 800, 1050]);  // Custom dimensions in points 800 width , 1050 height
        // Download the PDF
        return $pdf->download($student->name . '-application-form.pdf');
    }

    /**
     * Generate a migration certificate for a student.
     *
     * @param $id
     * @return Response|RedirectResponse|View
     */
    public function migrationForm($id): Response|RedirectResponse|View
    {
        return $this->generateCertificate($id, 'migration', 'migration-certificate');
    }

    /**
     * Generate a paramedical certificate for a student.
     *
     * @param $id
     * @return Response|RedirectResponse|View
     */
    public function paramedicalRegCertificate($id): Response|RedirectResponse|View
    {
        return $this->generateCertificate($id, 'paramedical-reg-certificate', 'paramedical-registration-certificate');
    }

    /**
     * Generate a paramedical certificate for a student.
     *
     * @param $id
     * @return Response|RedirectResponse|View
     */
    public function paramedicalCertificate($id): Response|RedirectResponse|View
    {
        return $this->generateCertificate($id, 'paramedical-certificate', 'paramedical-certificate');
    }

    /**
     * Common logic for generating certificates.
     *
     * @param  $id
     * @param  $viewName
     * @param  $certificateType
     * @return Response|RedirectResponse|View
     */
    private function generateCertificate($id, $viewName, $certificateType): Response|RedirectResponse|View
    {
        $student = Students::find($id);
        if (!$student) {
            return redirect()->back()->with('validation_errors', ['Student not found.']);
        }

        // Calculate course duration in months
        $courseTotalMonth = $this->calculateCourseDuration($student->course);

        // Calculate completion date
        $admissionDate = Carbon::parse($student->admission_date);
        $completionDate = $admissionDate->copy()->addMonths($courseTotalMonth);

        // Adjust admission date if it's a Sunday
        if ($admissionDate->isSunday()) {
            $admissionDate->addDay(); // Move to the next day (Monday)
        }

        // Prepare data for the certificate
        $data = $this->prepareCertificateData($student, $admissionDate, $completionDate, $certificateType);

        // Generate PDF
        set_time_limit(300); // Set to 5 minutes (adjust if needed)
        $pdf = PDF::loadView("certificate.$viewName", ['student' => $student, 'data' => $data]);
        $pdf->setPaper([0, 0, 800, 1110]);
        $pdf->setOptions([
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'isRemoteEnabled' => true, // Allow loading images from URLs
            'margin-top' => 120,
            'margin-bottom' => 120,
            'margin-left' => 0,
            'margin-right' => 0,
        ]);

        return $pdf->download(strtolower($student->name) . "-$certificateType.pdf");
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
     * @return array
     */
    private function prepareCertificateData($student, $admissionDate, $completionDate, $certificateType): array
    {
        $baseUrl = env('LIVE_URL');
        $streamName = $student->course->stream->name;

        $data = [
            'stream_prefix' => $student->course->stream->enrollments->first()->name,
            'reg_no' => 'MIG/REF/SVITM/' . $completionDate->format('Y') . rand(0, 9),
            'completion_year' => $completionDate->format('m-d-Y'),
            'footer_date' => $admissionDate->format('d-M-Y'),
            'year' => $admissionDate->format('Y'),
        ];

        if ($certificateType === 'migration-certificate') {
            $data['certificate_image'] = in_array($streamName, ['ITI', 'TECHNOLOGY & MGMT']) ? $baseUrl . 'assets/img/certificates/technology/iti-and-tech-migration.png' : $baseUrl . 'assets/img/certificates/paramedical/paramedical-migration.png';
        } elseif ($certificateType == 'paramedical-certificate') {
            $data['certificate_image'] = $baseUrl . 'assets/img/certificates/paramedical/paramedical-certificate.png';
        } else {
            $data['certificate_image'] = $baseUrl . 'assets/img/certificates/paramedical/paramedical-registration-certificate.png';
        }
        $data['student_image'] = $student['photo']
            ? asset($baseUrl . 'storage/' . $student['photo'])
            : asset($baseUrl . 'assets/img/profileImage.png');
        $data['course_name'] = $student->course->name;
        $data['date_of_birth'] = Carbon::parse($student->dob)->format('d-M-Y');
        return $data;
    }
}
