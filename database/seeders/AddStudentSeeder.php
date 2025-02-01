<?php

namespace Database\Seeders;

use App\Models\Center;
use App\Models\Course;
use App\Models\Prefix;
use App\Models\Students;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = DB::table('old_students')->get();

        foreach ($students as $key => $student) {
            $course = Course::where('name', $student->course_name)->first();

            if (!$course) {
                continue; // Skip if course not found
            }

            $input = $student->enrolment_no_start;
            $parts = explode("/", $input);

            if (count($parts) < 2) {
                continue; // Skip if format is invalid
            }

            $firstPart = $parts[0] . "/" . $parts[1];
            $prefix = Prefix::where('prefix', $firstPart . '/')->first();
            if (!$prefix) {
                continue; // Skip if prefix not found
            }

            $oldEnrollment = DB::table('old_students')
                ->where('enrolment_no_start', 'like', '%' . $prefix->prefix . '%')
                ->where('id', $student->id)
                ->first();

            if (!$oldEnrollment) {
                continue; // Skip if old enrollment not found
            }

            $newParts = explode("/", $oldEnrollment->enrolment_no_start);

            if (count($newParts) < 4) {
                continue; // Skip if format is invalid
            }

            $newSecondPart = $newParts[2] . "/" . $newParts[3];

            // Find the correct center for this student
            $center = DB::table('old_users')
                ->where('id', $student->center_id) // Assuming `center_id` exists in `old_students`
                ->first();
            if (!$center) {
                continue; // Skip if center not found
            }

            $savedCenter = User::where('email', 'like', '%' . $center->email . '%')->first();

            if (!$savedCenter) {
                continue; // Skip if mapped user (center) not found
            }
            // Insert only once per student
            Students::create([
                'center_id' => $savedCenter->id,
                'course_id' => $course->id,
                'enrollment' => $newSecondPart,
                'name' => ucfirst($student->name),
                'father_name' => ucfirst($student->father_name),
                'mother_name' => ucfirst($student->mother_name),
                'dob' => $student->dob ? Carbon::parse($student->dob)->format('Y-m-d') : null,
                'registration_date' => $student->reg_date ? Carbon::parse($student->reg_date)->format('Y-m-d') : null,
                'admission_date' => $student->admission_date ? Carbon::parse($student->admission_date)->format('Y-m-d') : null,
                'gender' => $student->gender,
                'mobile_number' => $student->mobile_number,
                'state' => $student->state,
                'mode' => $student->mode,
                'lateral_entry' => $student->laterl_entry == 'No' ? 0 : 1,
                'term_and_conditions' => $student->term_condition == 'on' ? 1 : 0,
                'status' => $student->status == "0" ? 0 : 1,
            ]);
            $this->command->info("{$key} Added or found prefix: {$student->name}");
        }
    }
}
