<?php

namespace Database\Seeders;

use App\Models\AccountingCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 0;
        AccountingCategory::updateOrCreate(['id' => ++$i], 
        [
            'category_label' => 'Fee and Admission','category_type' => 1 ,'status_id' => 1
        ]
        );
        AccountingCategory::updateOrCreate(['id' => ++$i], 
        [
            'category_label' => 'Grading Fee','category_type' => 1 ,'status_id' => 1
        ]
        );
        AccountingCategory::updateOrCreate(['id' => ++$i], 
        [
            'category_label' => 'Transportation Fee','category_type' => 1 ,'status_id' => 1
        ]
        );
        AccountingCategory::updateOrCreate(['id' => ++$i], 
        [
            'category_label' => 'Rent(Star School branch)','category_type' => 1 ,'status_id' => 1
        ]
        );
        AccountingCategory::updateOrCreate(['id' => ++$i], 
        [
            'category_label' => 'Uniform (Sale)','category_type' => 1 ,'status_id' => 1
        ]
        );
        AccountingCategory::updateOrCreate(['id' => ++$i], 
        [
            'category_label' => 'Programe Remuneration','category_type' => 1 ,'status_id' => 1
        ]
        );
        AccountingCategory::updateOrCreate(['id' => ++$i], 
        [
            'category_label' => 'Others','category_type' => 1 ,'status_id' => 1
        ]
        );
        AccountingCategory::updateOrCreate(['id' => ++$i], 
        [
            'category_label' => 'Admission fee','category_type' => 1 ,'status_id' => 1
        ]
        );
        AccountingCategory::updateOrCreate(['id' => ++$i], 
        [
            'category_label' => 'Tution fee','category_type' => 1 ,'status_id' => 1
        ]
        );
        AccountingCategory::updateOrCreate(['id' => ++$i], 
        [
            'category_label' => 'Seminar Registration fee','category_type' => 1 ,'status_id' => 1
        ]
        );
        AccountingCategory::updateOrCreate(['id' => ++$i], 
        [
            'category_label' => 'Workshop registration fee','category_type' => 1 ,'status_id' => 1
        ]
        );
        /**expense  */
        AccountingCategory::updateOrCreate(['id' => ++$i], 
        [
            'category_label' => 'Rent (Satr, Qusais,Ajman)','category_type' => 2 ,'status_id' => 1
        ]
        );
        AccountingCategory::updateOrCreate(['id' => ++$i], 
        [
            'category_label' => 'Wifi','category_type' => 2 ,'status_id' => 1
        ]
        );
        AccountingCategory::updateOrCreate(['id' => ++$i], 
        [
            'category_label' => 'Mobile','category_type' => 2 ,'status_id' => 1
        ]
        );
        AccountingCategory::updateOrCreate(['id' => ++$i], 
        [
            'category_label' => 'Dewa','category_type' => 2 ,'status_id' => 1
        ]
        );
        AccountingCategory::updateOrCreate(['id' => ++$i], 
        [
            'category_label' => 'Stationary','category_type' => 2 ,'status_id' => 1
        ]
        );
        AccountingCategory::updateOrCreate(['id' => ++$i], 
        [
            'category_label' => 'Programe Expenses','category_type' => 2 ,'status_id' => 1
        ]
        );
        AccountingCategory::updateOrCreate(['id' => ++$i], 
        [
            'category_label' => 'Uniform (purchase)','category_type' => 2 ,'status_id' => 1
        ]
        );
        AccountingCategory::updateOrCreate(['id' => ++$i], 
        [
            'category_label' => 'Kacha','category_type' => 2 ,'status_id' => 1
        ]
        );
        AccountingCategory::updateOrCreate(['id' => ++$i], 
        [
            'category_label' => 'Electronics items','category_type' => 2 ,'status_id' => 1
        ]
        );
        AccountingCategory::updateOrCreate(['id' => ++$i], 
        [
            'category_label' => 'Medical,documents','category_type' => 2 ,'status_id' => 1
        ]
        );
        AccountingCategory::updateOrCreate(['id' => ++$i], 
        [
            'category_label' => 'Transportation','category_type' => 2 ,'status_id' => 1
        ]
        );
        AccountingCategory::updateOrCreate(['id' => ++$i], 
        [
            'category_label' => 'Advertising','category_type' => 2 ,'status_id' => 1
        ]
        );
        AccountingCategory::updateOrCreate(['id' => ++$i], 
        [
            'category_label' => 'Others','category_type' => 2 ,'status_id' => 1
        ]
        );
      


        
    }
}


