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
    public function certificate($id): Response|RedirectResponse|View
    {
        return $this->generateCertificate($id, 'certificate', 'certificate');
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

        $pdf = PDF::loadView("certificate.$viewName", ['student' => $student, 'data' => $data]);
        $pdf->setPaper([0, 0, 600, 850]);
        $pdf->setOptions([
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'isRemoteEnabled' => true, // Allow loading images from URLs
            'margin-top' => 0,
            'margin-bottom' => 0,
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
        $stream = $student->course->stream;
        $streamName = $stream->name;
        $prefix = $stream->enrollments->first()->prefix->prefix ?? '';
        $prefixParts = explode('/', $prefix);

        $data = [
            'stream_prefix' => $stream->enrollments->first()->name,
            'reg_no' => "MIG/REF/{$prefixParts[0]}/" . $completionDate->format('Y') . rand(0, 99),
            'para_reg_no' => $prefix . $student->enrollment,
            'completion_year' => $completionDate->format('m-d-Y'),
            'footer_date' => $completionDate->copy()->addMonths(2)->format('d-M-Y'),
            'reg_date' => $completionDate->format('d-M-Y'),
            'year' => $admissionDate->format('Y'),
            'year_completion' => $completionDate->format('Y'),
            'institute_name' => $this->getInstituteName($streamName),
            'roll_number' => $student->course->prefix->prefix . $student->rollNumbers()->latest('id')->first()->roll_number,
            'serial_number' => $completionDate->format('Yd') . rand(1000, 9999),
            'stream' => $streamName
        ];

        $data['certificate_image'] = $this->getCertificateImage($baseUrl, $streamName, $certificateType);
        $data['student_image'] = $student['photo']
            ? asset($baseUrl . 'storage/' . $student['photo'])
            : asset($baseUrl . 'assets/img/profileImage.png');
        $data['course_name'] = $student->course->name;
        $data['date_of_birth'] = Carbon::parse($student->dob)->format('d-M-Y');

        return $data;
    }

    private function getInstituteName(string $streamName): string
    {
        return match ($streamName) {
            'ITI' => 'SWAMI VIVEKANAND INDUSTRIAL & VOCATIONAL TRAINING INSTITUTE , SOHNA',
            'TECHNOLOGY & MGMT' => 'SWAMI VIVEKANAND INSTITUTE OF TECHNOLOGY & MANAGEMENT , SOHNA',
            default => 'SWAMI VIVEKANAND INSTITUTE OF PARAMEDICAL SCIENCE , SOHNA',
        };
    }

    private function getCertificateImage(string $baseUrl, string $streamName, string $certificateType): string
    {
        if ($certificateType === 'migration-certificate') {
            $imagePath = $streamName == 'ITI' ? 'iti/iti-migration.png' :
                ($streamName == 'TECHNOLOGY & MGMT' ? 'technology/tech-migration.png' :
                    'paramedical/paramedical-migration.png');


        } elseif ($certificateType == 'certificate') {
            $imagePath = $streamName == 'ITI' ? 'iti/iti-certificate.png' :
                ($streamName == 'TECHNOLOGY & MGMT' ? 'technology/tech-certificate.png' :
                    'paramedical/paramedical-certificate.png');
        } else {
            $imagePath = 'paramedical/paramedical-registration-certificate.png';
        }

        return $baseUrl . 'assets/img/certificates/' . $imagePath;
    }
}
