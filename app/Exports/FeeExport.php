<?php

namespace App\Exports;

use App\Models\{ Fee ,Status };
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FeeExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return User::select('email','students.id')->get();
    // }

    protected $fees;

    public function __construct(Collection $fees)
    {
        $this->fees = $fees;
    }

    public function collection()
    {
        return $this->fees->map(function ($fee) {
            return [
                'Name' => $fee->user->full_name."(". $fee->user->ID_Number.")",
                'Email' => $fee->user->email,
                'Fee Type' =>  feeTypelist()[$fee->fee_type] ,
                'Status' =>   $fee->status->status ,
                'Amount' =>  $fee->amount   ,
                'Discount' =>  $fee->discount   ,
                'Installment Nos' =>  $fee->installment_nos ,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Fee Type',
            'Status',
            'Amount' ,
            'Discount' ,
            'Installment Nos' ,
        ];
    }
}
