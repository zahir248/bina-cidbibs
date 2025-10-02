<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('1234'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@example.com');
        $this->command->info('Password: 1234');
    }
}