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
                'name' => ucfirst(strtolower($user->name)),
                'email' => strtolower($user->email),
                'phone' => $user->phone,
                'role' => $user->role == 'center' ? 'Center' : 'User',
                'password' => $user->password ?: Hash::make('Test@12345'),
                'status' => (bool)$oldCenter->status
            ]);
            Center::create([
                'user_id' => $newUser->id,
                'registration_prefix' => $oldCenter->registration_prefix,
                'owner_name' => ucfirst(strtolower($oldCenter->owner_name)),
                'state' => ucfirst(strtolower($oldCenter->state)),
                'address' => $oldCenter->address,
            ]);
            $this->command->info("{$key} Center {$newUser->email} Added Successfully");
        }
    }
}
