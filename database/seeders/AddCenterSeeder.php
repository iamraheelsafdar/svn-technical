<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Center;
use App\Models\User;

class AddCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $oldUser = DB::table('old_users')->where('role', 'Center')->get();
        foreach ($oldUser as $key => $user) {
            $oldCenter = DB::table('old_centers')->where('user_id', $user->id)->first();

            $newUser = User::create([
                'name' => trim(ucfirst(strtolower($user->name))),
                'email' => trim(strtolower($user->email)),
                'phone' => trim($user->phone),
                'role' => $user->role == 'center' ? 'Center' : 'User',
                'password' => $user->password ?: Hash::make('Test@12345'),
                'status' => (bool)$oldCenter->status
            ]);
            Center::create([
                'user_id' => $newUser->id,
                'registration_prefix' => trim($oldCenter->registration_prefix),
                'owner_name' => trim(ucfirst(strtolower($oldCenter->owner_name))),
                'state' => trim(ucfirst(strtolower($oldCenter->state))),
                'address' => trim($oldCenter->address),
            ]);
            $this->command->info("{$key} Center {$newUser->email} Added Successfully");
        }
    }
}
