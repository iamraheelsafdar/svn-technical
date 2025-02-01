<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $oldCourses = DB::table('old_svn_subjects')->get();
        foreach ($oldCourses as $oldCourse) {

        $this->command->info("Subjects added successfully {$oldCourse->subject_name}");
        }
    }
}
