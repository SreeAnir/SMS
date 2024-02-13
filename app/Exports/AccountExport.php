<?php

namespace App\Exports;

use App\Models\{ acounting ,Status };
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AccountExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return User::select('email','students.id')->get();
    // }

    protected $acountings;

    public function __construct(Collection $acountings)
    {
        $this->acountings = $acountings;
    }

    public function collection()
    {
        return $this->acountings->map(function ($acounting) {
            return [
                'Type' => $acounting->category_type_label ,
                'Category' => $acounting->category->category_label ,
                'Amount' => $acounting->amount,
                'Location' => $acounting->location?->name,
                'Date' => $acounting->location?->date,
                'Added On' => $acounting->created_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Type',
            'Category',
            'Amount',
            'Location',
            'Date' ,
            'Added On' ,
        ];
    }
}
