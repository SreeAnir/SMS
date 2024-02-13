<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return User::select('email','students.id')->get();
    // }

    protected $users;

    public function __construct(Collection $users)
    {
        $this->users = $users;
    }

    public function collection()
    {
        return $this->users->map(function ($user) {
            return [
                'Name' => $user->full_name,
                'Email' => $user->email,
                'Phone' => $user->full_phone_number,
                'Location' => $user->location?->name,
                'Kacha' =>  $user?->student?->kacha?->label ,
                'Batch' =>  $user->student?->batches->first()?->batch_name ,
                // Add more columns as needed, including 'created_at' from payments
                // 'Payment Amount' => optional($user->student)->id,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Phone',
            'Location',
            'Kacha',
            'Batch'
            // 'Payment Amount',
            // 'Payment Created At',
            // Add more headings as needed
        ];
    }
}
