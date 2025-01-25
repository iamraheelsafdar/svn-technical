<?php

namespace Database\Seeders;

use App\Models\Enrollment;
use App\Models\Prefix;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\SvnStream;

class AddSvnStreamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $svnstream = DB::table('old_svn_streams')->get();
        foreach ($svnstream as $stream) {
            $newStream = SvnStream::create([
                'name' => trim($stream->stream_name),
                'status' => 1,
            ]);
            $session = DB::table('old_svn_sessions')->where('stream_type', $stream->id)->first();
            $prefixes = Prefix::where('prefix', $session->enrollment_no_start)->first();
            Enrollment::create([
                'stream_id' => $newStream->id,
                'prefix_id' => $prefixes->id,
                'name' => trim($session->session_name),
                'year_start' => $session->year_start,
            ]);
            $this->command->info('Enrollment created: ' . $session->session_name);
        }

    }
}
