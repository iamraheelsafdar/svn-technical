<?php

namespace Database\Seeders;

use App\Models\Subject;
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
        $oldCourses = DB::table('old_course_managements')
            ->selectRaw('MIN(id) as id, course_name, course_code, course_type, course_semesters, roll_no, course_stream, course_status, course_semesters, created_at, updated_at')
            ->groupBy('course_name', 'course_code', 'course_type', 'course_semesters', 'roll_no','course_stream','course_status', 'course_semesters', 'created_at','updated_at')
            ->get();

        foreach ($oldCourses as $oldCourse) {
            // Fetch the prefix and stream
            $prefix = Prefix::where('prefix', $oldCourse->roll_no)->first();
            $svnStream = SvnStream::where('id', $oldCourse->course_stream)->first();

            if (!$prefix || !$svnStream) {
                $this->command->alert("Missing prefix or stream for course: {$oldCourse->course_name}");
                continue; // Skip to the next course if required data is missing
            }

            // Prepare the course data
            $courseData = [
                'stream_id' => $svnStream->id,
                'prefix_id' => $prefix->id,
                'old_course_id' => $oldCourse->id,
                'name' => trim($oldCourse->course_name),
                'code' => trim($oldCourse->course_code),
                'duration' => $oldCourse->course_semesters,
                'status' => (bool)$oldCourse->course_status,
                'type' => trim(strtolower($oldCourse->course_type)),
                'created_at' => $oldCourse->created_at,
                'updated_at' => $oldCourse->updated_at,
            ];

            // Create a new course
            $course = Course::create($courseData);

            if (!$course) {
                $this->command->alert("Failed to create course: {$oldCourse->course_name}");
                continue; // Skip if the course was not created
            }

            // Fetch and insert subjects for the course
//            $subjects = DB::table('old_svn_subjects')
//                ->where('course_id', $oldCourse->id)
//                ->selectRaw('MIN(id) as id, course_type_id, subject_name, subject_code, sub_min_marks, sub_max_marks, subject_practical, p_min_marks, p_max_marks, semester_name, semester_rollno_start, sem_year_code, created_at, updated_at')
//                ->groupBy('course_type_id', 'subject_name', 'subject_code', 'sub_min_marks', 'sub_max_marks', 'subject_practical', 'p_min_marks', 'p_max_marks', 'semester_name', 'semester_rollno_start', 'sem_year_code', 'created_at', 'updated_at')
//                ->get();
            $subjects = DB::table('old_svn_subjects')
                ->where('course_id', $oldCourse->id)
                ->selectRaw('
                    MIN(id) as id,
                    MIN(course_type_id) as course_type_id,
                    subject_name,
                    subject_code,
                    sub_min_marks,
                    MIN(sub_max_marks) as sub_max_marks,
                    MIN(subject_practical) as subject_practical,
                    p_min_marks,
                    p_max_marks,
                    MIN(semester_name) as semester_name,
                    MIN(semester_rollno_start) as semester_rollno_start,
                    MIN(sem_year_code) as sem_year_code,
                    MIN(created_at) as created_at,
                    MAX(updated_at) as updated_at
                ')
                ->groupBy('course_type_id','course_id','subject_name', 'subject_code', 'sub_max_marks','sub_min_marks', 'p_min_marks', 'p_max_marks')
                ->get();
//            $subjects = DB::table('old_svn_subjects')->where('course_id', $oldCourse->id)->get();
            foreach ($subjects as $subject) {
                $duration = DB::table('old_course_types')->where('id', $subject->course_type_id)->first();

                if (!$duration || !isset($duration->slug)) {
                    $this->command->alert("Missing duration for subject: {$subject->subject_name}");
                    continue; // Skip this subject if duration is missing
                }

                // Extract the number from the slug
                $string = $duration->slug;
                $parts = explode('-', $string);
                $number = end($parts);

                // Insert the subject
                Subject::create([
                    'course_id' => $course->id,
                    'duration_part' => $number,
                    'name' => $subject->subject_name,
                    'code' => $subject->subject_code,
                    'min_marks' => $subject->sub_min_marks,
                    'max_marks' => $subject->sub_max_marks,
                    'is_practical' => $subject->subject_practical == '0' ? 0 : 1,
                    'practical_min_marks' => $subject->p_min_marks === 'undefined' ? null : $subject->p_min_marks,
                    'practical_max_marks' => $subject->p_max_marks === 'undefined' ? null : $subject->p_max_marks,
                ]);
            }

            // Print success message
            $this->command->info("Course {$oldCourse->course_name} ({$oldCourse->course_code}) created successfully.");
        }
    }
}
