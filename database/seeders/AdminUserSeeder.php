<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'first_name' => 'Super Admin',
                'last_name' => 'Super Admin',
                'email' => 'su@test.com',
                'password' => Hash::make('Kal!@r#'),
                'user_type' => 1,
                'email_verified_at' =>now()
            ],
            [
                'first_name' => 'Developer',
                'last_name' => '',
                'email' => 'dev@test.com',
                'password' => Hash::make('Kal!@r#'),
                'user_type' => 1,
                'email_verified_at' =>now()
            ],
            [
                'first_name' => 'Admin',
                'last_name' => '',
                'email' => 'admin1@test.com',
                'user_type' => 2,
                'password' => Hash::make('Test@123'),
                'email_verified_at' => now()
            ],
            [
                'first_name' => 'Main Accountant',
                'last_name' => '',
                'email' => 'admin2@test.com',
                'user_type' => 2,
                'password' => Hash::make('Test@123'),
                'email_verified_at' =>now()
            ],
            [
                'first_name' => 'Branch Admin',
                'last_name' => '',
                'email' => 'admin3@test.com',
                'user_type' => 2,
                'password' => Hash::make('Test@123'),
                'email_verified_at' => now()
            ],
            [
                'first_name' => 'Branch Accountant',
                'last_name' => '',
                'email' => 'account1@test.com',
                'user_type' => 2,
                'password' => Hash::make('Test@123'),
                'email_verified_at' => now()
            ],
        ];
        foreach ($users as $user) {
            $result = User::query()->updateOrCreate(['email' => $user['email']], $user  );
            $result->save();
        }
    }
}
