<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Prefix;

class AddPrefixesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $oldPrefixes = DB::table('old_svn_prefix_starts')->get();
        foreach ($oldPrefixes as $key => $oldPrefix) {
            $prefix = Prefix::firstOrCreate([
                'prefix' => trim($oldPrefix->reg_prefix),  // Search condition
            ], [
                'prefix_assign_to' => $oldPrefix->table_name == 'course_managements' ? 'Course Management' : 'Svn Enrollment',
                'status' => (bool)$oldPrefix->status,
            ]);
            $this->command->info("{$key} Added or found prefix: {$prefix->prefix}");
        }
    }
}
