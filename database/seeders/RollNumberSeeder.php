<?php

namespace Database\Seeders;

use App\Models\StudentRollNumber;
use App\Models\Students;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RollNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = DB::table('old_students')->get();

        foreach ($students as $student) {
            // Fetch only relevant roll numbers for the current student
            $rollNumbers = DB::table('old_student_roll_numbers')
                ->where('student_id', $student->id) // Assuming `student_id` exists
                ->get();

            // Find the student in the new system
            $savedStudent = Students::where('father_name', $student->father_name)
                ->where('mother_name', $student->mother_name)
                ->where('name', $student->name)
                ->whereHas('course', function ($q) use ($student) {
                    $q->where('duration', $student->course_duration);
                })
                ->first();

            // Skip if no matching student found
            if (!$savedStudent) {
                $this->command->info("Skipping student: {$student->name} (Not Found)");
                continue;
            }

            foreach ($rollNumbers as $rollNumber) {
                // Extract roll number part
                if (preg_match('/\d{4}\/\d+\/\d+/', $rollNumber->roll_number, $matches)) {
                    $extractedPart = $matches[0];

                    // Ensure roll number is not null
                    if (!empty($extractedPart)) {
                        StudentRollNumber::create([
                            'student_id'  => $savedStudent->id,
                            'roll_number' => $extractedPart,
                        ]);
                    }
                }
            }

            $this->command->info("Student: {$student->name} roll number inserted successfully.");
        }
    }
}
