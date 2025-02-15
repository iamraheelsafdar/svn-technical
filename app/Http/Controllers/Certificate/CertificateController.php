<?php

namespace App\Http\Controllers\Certificate;

use App\Http\Controllers\Controller;
use App\Models\Students;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DateInterval;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\Factory;

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
        $pdf = PDF::loadView('certificate.forms.application-form', ['student' => $student]);
        $pdf->setPaper([0, 0, 800, 1050]);  // Custom dimensions in points 800 width , 1050 height
        // Download the PDF
        return $pdf->download('application_form.pdf');
    }

    /**
     * @param $id
     * @return Response|RedirectResponse|View
     */
    public function migrationForm($id): Response|RedirectResponse|View
    {
        $student = Students::find($id);
        if (!$student) {
            return redirect()->back()->with('validation_errors', ['Student not found.']);
        }

        // Calculate course duration in months
        $courseTotalMonth = $student->course->type == 'year'
            ? $student->course->duration * 12
            : ($student->course->type == 'semester'
                ? $student->course->duration * 6
                : $student->course->duration);

        // Calculate completion date
        $admissionDate = Carbon::parse($student->admission_date);
        $completionDate = $admissionDate->copy()->addMonths($courseTotalMonth);
        if ($admissionDate->isSunday()) {
            $admissionDate->addDay(); // Move to the next day (Monday)
        }
        // Prepare data for the certificate
        $data = [
            'stream_prefix' => $student->course->stream->enrollments->first()->name,
            'reg_no' => in_array($student->course->stream->first()->name, ['ITI', 'TECHNOLOGY & MGMT'])
                ? 'MIG/REF/SVITM/' . $completionDate->format('Y') . rand(0, 9)
                : '',
            'completion_year' => $completionDate->format('m-d-Y'),
            'certificate_image' => in_array($student->course->stream->first()->name, ['ITI', 'TECHNOLOGY & MGMT'])
                ? env('LIVE_URL') . 'assets/img/certificates/migration/iti-and-tech-migration.png'
                : env('LIVE_URL') . 'assets/img/certificates/migration/paramedical-migration.png',
            'footer_date' => $admissionDate->format('d-M-Y'),
        ];
        set_time_limit(300); // Set to 5 minutes (adjust if needed)
        // Generate PDF
        $pdf = PDF::loadView('certificate.migration.migration', ['student' => $student, 'data' => $data]);
//        $pdf->setPaper('a4', 'portrait');
//
//        // Enable remote images and set default font
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
        return $pdf->download(strtolower($student->name) . '-migration-certificate.pdf');
    }
}
