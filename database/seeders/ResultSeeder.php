<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Prefix;
use App\Models\StudentResult;
use App\Models\Students;
use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allNewStudents = Students::all();

        foreach ($allNewStudents as $allNewStudent) {
            $allNewCourse = Course::find($allNewStudent->course_id);

            if (!$allNewCourse) {
                $this->command->warn("Course not found for student {$allNewStudent->name}");
                continue;
            }

            $prefix = Prefix::where('id', $allNewCourse->prefix_id)->first();

            $oldCourse = DB::table('old_course_managements')
                ->where('course_name', 'like', "%{$allNewCourse->name}%")
                ->where('course_code', 'like', "%{$allNewCourse->code}%")
                ->where('course_type', 'like', "%{$allNewCourse->type}%")
                ->where('course_semesters', $allNewCourse->duration)
                ->where('roll_no', $prefix->prefix)
                ->first();

            if (!$oldCourse) {
                $this->command->warn("Old course not found for new course: {$allNewCourse->name}");
                continue;
            }

            $oldStudent = DB::table('old_students')
                ->where('name', 'like', "%{$allNewStudent->name}%")
                ->where('email', 'like', "%{$allNewStudent->email}%")
                ->where('father_name', 'like', "%{$allNewStudent->father_name}%")
                ->where('mother_name', 'like', "%{$allNewStudent->mother_name}%")
                ->where('mode', 'like', "%{$allNewStudent->mode}%")
                ->where('gender', 'like', "%{$allNewStudent->gender}%")
                ->where('course_id', $oldCourse->id)
                ->first();

            if (!$oldStudent) {
                $this->command->warn("Old student not found for new student: {$allNewStudent->name}");
                continue;
            }

            $newSavedSubjects = Subject::where('course_id', $allNewCourse->id)->get();

            foreach ($newSavedSubjects as $newSubject) {
                $duration = DB::table('old_course_types')->where('course_id',$oldCourse->id)->where('slug','like',"%$newSubject->duration_part%")->first();
                $oldSubject = DB::table('old_svn_subjects')
                    ->where('course_id', $oldCourse->id)
                    ->where('subject_name', 'like', "%{$newSubject->name}%")
                    ->where('p_min_marks' , $newSubject->practical_min_marks == null ? 'undefined' : $newSubject->practical_min_marks)
                    ->where('sub_min_marks' , $newSubject->min_marks)
                    ->where('p_max_marks' , $newSubject->practical_max_marks == null ? 'undefined' : $newSubject->practical_max_marks)
                    ->where('sub_max_marks' , $newSubject->max_marks)
                    ->where('subject_code' , $newSubject->code)
                    ->where('subject_practical' , $newSubject->is_practical)
                    ->where('course_type_id' , $duration->id)
                    ->first();
                $oldResult = DB::table('old_student_results')
                    ->where('student_id', $oldStudent->id)
                    ->where('course_id', $oldCourse->id)
                    ->where('subject_name', 'like', "%{$newSubject->name}%")
                    ->where('subject_code', $newSubject->code)
                    ->where('subject_id', $oldSubject->id)
                    ->first();

                if (!$oldResult) {
                    $this->command->warn("No old result found for subject: {$newSubject->name}");
                    continue;
                }

                StudentResult::create([
                    'student_id' => $allNewStudent->id,
                    'subject_id' => $newSubject->id,
                    'subject_obtained_marks' => $oldResult->theory_marks,
                    'practical_obtained_marks' => $oldResult->practical_marks,
                ]);

                $this->command->info("Result of student {$allNewStudent->name} for subject {$newSubject->name} created successfully.");
            }
        }
    }
}
