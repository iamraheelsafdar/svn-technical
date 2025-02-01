<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            AddCenterSeeder::class,
            AddPrefixesSeeder::class,
            AddSvnStreamSeeder::class,
            UpdateCenterImages::class,
            CourseSeeder::class,
            AddStudentSeeder::class,
        ]);

    }
}
