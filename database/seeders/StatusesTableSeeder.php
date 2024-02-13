<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 0;
        Status::updateOrCreate(['id' => ++$i], [
            'status' => 'Active',
        ]);
        Status::updateOrCreate(['id' => ++$i], [
            'status' => 'Inactive',
        ]);
        Status::updateOrCreate(['id' => ++$i], [
            'status' => 'Pending',
        ]);
        Status::updateOrCreate(['id' => ++$i], [
            'status' => 'Expired',
        ]);
        Status::updateOrCreate(['id' => ++$i], [
            'status' => 'Draft',
        ]);
        Status::updateOrCreate(['id' => ++$i], [
            'status' => 'Published',
        ]);
        Status::updateOrCreate(['id' => ++$i], [
            'status' => 'Sent',
        ]);
        Status::updateOrCreate(['id' => ++$i], [
            'status' => 'Not Sent',
        ]);
        Status::updateOrCreate(['id' => ++$i], [
            'status' => 'Sending',
        ]);
        Status::updateOrCreate(['id' => ++$i], [
            'status' => 'Unpaid',
        ]);
        Status::updateOrCreate(['id' => ++$i], [
            'status' => 'Paid',
        ]);
        Status::updateOrCreate(['id' => ++$i], [
            'status' => 'Pending Payment',
        ]);
        
       
        
        // Status::updateOrCreate(['id' => ++$i], [
        //     'en' => [
        //         'status' => 'Payment Pending',
        //     ],
        //     'ar' => [
        //         'status' => 'Payment Pending',
        //     ],
        // ]);
        // Status::updateOrCreate(['id' => ++$i], [
        //     'en' => [
        //         'status' => 'Payment Completed',
        //     ],
        //     'ar' => [
        //         'status' => 'Payment Completed',
        //     ],
        // ]);
        // Status::updateOrCreate(['id' => ++$i], [
        //     'en' => [
        //         'status' => 'Payment Failed',
        //     ],
        //     'ar' => [
        //         'status' => 'Payment Failed',
        //     ],
        // ]);
        // Status::updateOrCreate(['id' => ++$i], [
        //     'en' => [
        //         'status' => 'Payment Completed & Server Error',
        //     ],
        //     'ar' => [
        //         'status' => 'Payment Completed & Server Error',
        //     ],
        // ]);
    }
}


