<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\SvnStream;
use App\Models\Course;
use App\Models\Prefix;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $oldCourses = DB::table('old_course_managements')->get();

        foreach ($oldCourses as $key => $oldCourse) {
            // Fetch the prefix and stream
            $prefix = Prefix::where('prefix', $oldCourse->roll_no)->first();
            $svnStream = SvnStream::where('id', $oldCourse->course_stream)->first();

            // Prepare the course data
            $courseData = [
                'stream_id' => $svnStream->id,
                'prefix_id' => $prefix->id,
                'name' => trim($oldCourse->course_name),
                'code' => trim($oldCourse->course_code),
                'duration' => $oldCourse->course_semesters,
                'status' => (bool)$oldCourse->course_status,
                'type' => trim(strtolower($oldCourse->course_type)),
                'created_at'    => $oldCourse->created_at,
                'updated_at'    => $oldCourse->updated_at,
            ];

            // Use updateOrInsert to avoid duplicates
            $existingCourse = Course::updateOrInsert(
                ['code' => $oldCourse->course_code, 'name' => $oldCourse->course_name], // Conditions to check for existing records
                $courseData // Data to insert or update
            );

            // Print a message based on whether a new course was created or not
            if ($existingCourse) {
                $this->command->info("Course {$oldCourse->course_name} ({$oldCourse->course_code}) inserted or updated");
            } else {
                $this->command->alert("Duplicate course found: {$oldCourse->course_name} ({$oldCourse->course_code})");
            }
        }
    }
}
