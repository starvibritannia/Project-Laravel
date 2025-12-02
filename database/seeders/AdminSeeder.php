<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin Lab',
            'email' => 'admin@iot.com', // Email untuk login
            'password' => Hash::make('123'), // Password login
        ]);
    }
}