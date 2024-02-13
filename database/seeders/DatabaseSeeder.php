<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CountrySeeder::class);
        $this->call(StatusesTableSeeder::class);
        $this->call(AdminUserSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(StatusesTableSeeder::class);
    }
}
