<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    const CASH = 1 ;
    const UPI = 2 ;
    const CREDIT_CARD = 3 ;
    const NET_BANKING = 4 ;
    public static function list()
    {
        return [ self::CASH =>  "Cash" ,  self::UPI =>  'Upi' ,  self::CREDIT_CARD => 'Credit cart' , self::NET_BANKING => 'Net Banking' ];
    }
}
