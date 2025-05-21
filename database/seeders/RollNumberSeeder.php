<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use App\Models\StudentRollNumber;
use Illuminate\Database\Seeder;
use App\Models\Students;
use Carbon\Carbon;

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
            $savedStudent = Students::where('mother_name', 'like', "%{$student->mother_name}%")
                ->where('father_name', 'like', "%{$student->father_name}%")
                ->where('name', 'like', "%{$student->name}%")
                ->where('email', 'like', "%{$student->email}%")
                ->where('lateral_duration', $student->lateral_duration)
                ->where('lateral_entry', $student->laterl_entry == 'No' ? 0 : 1)
                ->whereHas('course', function ($q) use ($student) {
                    $q->where('duration', $student->course_duration);
                })
                ->first();

            // Skip if no matching student found
            if (!$savedStudent) {
                $this->command->info("Skipping student: {$student->name} (Not Found)");
                continue;
            }

            // Generate session periods once per student
            $registrationDate = Carbon::parse($savedStudent->registration_date);
            $courseType = $savedStudent->course->type; // 'semester' or 'year'
            $sessions = [];
            $sessionCounter = 1;
            $currentDate = clone $registrationDate;

            while ($sessionCounter <= 8) { // Assuming max 8 semesters or 4 years
                $sessionStart = $currentDate->format('M Y');

                if ($courseType == 'semester') {
                    $currentDate->addMonths(5)->endOfMonth(); // Move 5 months ahead, then set to end of the month
                } else {
                    $currentDate->addMonths(11)->endOfMonth(); // Move 11 months ahead, then set to end of the month
                }

                $sessionEnd = $currentDate->format('M Y');
                $sessions[$sessionCounter] = "{$sessionStart} - {$sessionEnd}";

                $sessionCounter++;
                $currentDate->addDay(); // Move to the next session
            }

            // Now insert roll numbers with correct sessions
            foreach ($rollNumbers as $key => $rollNumber) {
                // Extract roll number part
                if (preg_match('/\d{4}\/\d+\/\d+/', $rollNumber->roll_number, $matches)) {
                    $extractedPart = $matches[0];

                    // Extract the year from roll number
                    preg_match('/\d{4}/', $rollNumber->roll_number, $matches);
                    $year = $matches[0] ?? null;

                    // Ensure roll number is not null
                    if (!empty($extractedPart)) {
                        // Assign each roll number a session based on its order
                        $sessionIndex = min($key + 1, count($sessions)); // Prevent out-of-bounds errors
                        $session = $sessions[$sessionIndex];

                        $sessionParts = explode(" - ", $session);
                        $sessionEnd = end($sessionParts); // Get the second part of the session
                        $year = Carbon::parse($sessionEnd)->year; // Extract correct year

                        StudentRollNumber::create([
                            'student_id' => $savedStudent->id,
                            'old_roll_number_id' => $rollNumber->id,
                            'year' => $year, // Use session end year
                            'session' => $session,
                            'roll_number' => $extractedPart,
                            'duration' => $sessionIndex
                        ]);
                    }
                }
            }

            $this->command->info("Student: {$student->name} roll number inserted successfully.");
        }
    }
}
