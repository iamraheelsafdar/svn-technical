<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'amarp1451@gmail.com',
            'password' => Hash::make('Test@12345'),
            'phone' => '8168214400',
            'role' => 'Admin',
        ]);
    }
}
