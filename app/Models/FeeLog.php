<?php

namespace App\Models;
use App\Models\Status;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Fee ;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasStatus;
use DateTime;

class FeeLog extends Model
{
    use HasFactory,SoftDeletes,HasStatus;
    protected $guarded = ['id']; 
    public $timestamps = true;


    public function fee()
    {
        return $this->belongsTo(Fee::class, 'fee_id');
    }
    
    public function isPaid()
    {
        return ($this->status_id == Status::STATUS_PAID  );
    }
    // public function getStudentIDAttribute()
    // {
    //     return ($this->attributes['ID_Number']?$this->attributes['ID_Number'] :$this->attributes['id'] );
    // }
    public function getDueDateAttribute(){
        $payment_due_date = $this->attributes['payment_due_date'] ;
        $dueDate = new DateTime( $payment_due_date);
        $currentDate = new DateTime();

        if ($currentDate > $dueDate) {
            return "The due date has passed.\n";
        } else {
            $interval = $currentDate->diff($dueDate);
            $daysDifference = $interval->format('%a');

             $monthsDifference = ($interval->y * 12) + $interval->m;

             if ($daysDifference == 0) {
                return  "The payment is due today.\n";
            } elseif ($daysDifference == 1) {
                return  "The payment is due tomorrow.\n";
            } else {
                return  "The next payment is due in $daysDifference days.\n";
            }

            // Alternatively, you can use months for longer periods
            if ($monthsDifference >= 1) {
                return  "The next payment is due in $monthsDifference months.\n";
            }
        }
    }
}
