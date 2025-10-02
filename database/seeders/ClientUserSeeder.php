<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ClientUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientUsers = [
            [
                'name' => 'John Smith',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'role' => 'client',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah@example.com',
                'password' => Hash::make('password'),
                'role' => 'client',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Mike Wilson',
                'email' => 'mike@example.com',
                'password' => Hash::make('password'),
                'role' => 'client',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Lisa Brown',
                'email' => 'lisa@example.com',
                'password' => Hash::make('password'),
                'role' => 'client',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'David Lee',
                'email' => 'david@example.com',
                'password' => Hash::make('password'),
                'role' => 'client',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($clientUsers as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $this->command->info('Client users created successfully!');
    }
}
