<?php

namespace App\Exports;

use App\Http\Controllers\Certificate\CertificateController;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentExport implements FromCollection, WithHeadings
{

    public mixed $students;

    public function __construct($students)
    {
        $this->students = $students;

    }

    public function headings(): array
    {
        return ["Student Enrolment No", "Student Name", "Student dob", "Father Name", "Mother Name", "Course Name", "Stream", "Registration Date", "course Duration", "Ref Name", 'Institue'];
    }

    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        $records = [];
        foreach ($this->students as $student) {
            $records[] = [
                'enrolment_no_start' => ($student->course->stream->enrollments->first()->prefix->prefix ?? '') . $student->enrollment,
                'student_name' => $student->name,
                'student_dob' => Carbon::parse($student->dob)->format('d-m-Y'),
                'father_name' => $student->father_name,
                'mother_name' => $student->mother_name,
                'course_name' => $student->course->name,
                'stream' => $student->course->stream->name,
                'registration_date' => Carbon::parse($student->registration_date)->format('d-m-Y'),
                'course_duration' => $student->course->duration,
                'ref_name' => $student->reference->reference ?? '-',
                'institute_name' => CertificateController::getInstituteName($student->course->stream->name , $student)
            ];
        }
        return collect($records);
    }
}
