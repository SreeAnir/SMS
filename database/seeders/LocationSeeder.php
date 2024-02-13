<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Al Qusais',
            ],
            [
                'name' => 'Ras Al Khaimah',
            ],
            [
                'name' => 'Ajman',
            ],
            [
                'name' => 'Umm Al Quwain    ',
            ],
            
        ];
        foreach ($locations as $locations) {
            $result = Location::query()->updateOrCreate(['name' => $locations['name']]);
            $result->save();
        }
    }
}
