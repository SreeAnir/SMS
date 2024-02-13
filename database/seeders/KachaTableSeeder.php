<?php

namespace Database\Seeders;

use App\Models\Kacha;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class KachaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('kachas')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $i = 0;
        Kacha::updateOrCreate(['id' => ++$i], [
            'level' => 1,
            'next_label' => 'WHITE TO BLUE',
            'label' => 'WHITE',
            'color' => 'WHITE',
            'class_count' => 40  ,
            'months' => 4 ,
        ]);

        Kacha::updateOrCreate(['id' => ++$i], [
            'level' => 2,
            'next_label' => 'BLUE TO GREEN',
            'label' => 'BLUE',
            'color' => 'BLUE',
            'class_count' => 40  ,
            'months' => 4 ,
        ]);
        Kacha::updateOrCreate(['id' => ++$i], [
            'level' => 3,
            'next_label' => 'GREEN TO YELLOW',
            'label' => 'GREEN',
            'color' => 'GREEN',
            'class_count' => 40  ,
            'months' => 4 ,
        ]);
        Kacha::updateOrCreate(['id' => ++$i], [
            'level' => 4,
            'next_label' => 'YELLOW TO ORANGE',
            'label' => 'YELLOW',
            'color' => '#FFFF00',
            'class_count' => 40  ,
            'months' => 4 ,
        ]);
         
        Kacha::updateOrCreate(['id' => ++$i], [
            'level' => 5 ,
            'next_label' => 'ORANGE TO PURPLE',
            'label' => 'ORANGE',
            'color' => 'ORANGE',
            'class_count' => 40  ,
            'months' => 4 ,
        ]);
        Kacha::updateOrCreate(['id' => ++$i], [
            'level' => 6,
            'next_label' => 'PURPLE TO VIOLET',
            'label' => 'PURPLE',
            'color' => 'PURPLE',
            'class_count' => 40  ,
            'months' => 4 ,
        ]);
        Kacha::updateOrCreate(['id' => ++$i], [
            'level' => 7 ,
            'next_label' => 'VIOLET TO INDIGO',
            'label' => 'VIOLET',
            'color' => 'VIOLET',
            'class_count' => 40  ,
            'months' => 4 ,
        ]);
         

        Kacha::updateOrCreate(['id' => ++$i], [
            'level' => 8,
            'next_label' => 'INDIGO TO BROWN',
            'label' => 'INDIGO',
            'color' => 'INDIGO',
            'months' => 10 ,
            'class_count' => 100  ,
        ]);
         
        Kacha::updateOrCreate(['id' => ++$i], [
            'level' => 9 ,
            'next_label' => 'BROWN TO BLACK',
            'label' => 'BROWN',
            'color' => 'BROWN',
            'months' => 12 ,
            'class_count' => 140  ,
        ]);
        Kacha::updateOrCreate(['id' => ++$i], [
            'level' => 12  ,
            'next_label' => '',
            'label' => 'BLACK',
            'color' => 'BLACK',
            'months' => 12  ,
            'class_count' => 0  ,
        ]);
         
    }
}


