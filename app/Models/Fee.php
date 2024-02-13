<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FeeLog ;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\HasStatus;


class Fee extends Model
{
    use HasFactory,HasStatus;

    const YEARLY            = 12;
    const HALF_YEARLY            = 6;
    const MONTHLY              = 1;
    const QUARTERLY              = 4 ;

    protected $guarded = ['id'];  
    public const PERMISSION_FEE_LIST = 'List Fee';
    public const PERMISSION_FEE_MANAGE = 'Manage Fee';

    public function scopeFilterFromRequest(Builder $query)
    {
        if (request()->filled('search')) {
            if(request()->get('search')['value']!=null){
            $query->filterByName(request()->get('search')['value']);
            // ->orWhere('email', 'LIKE', '%'.request()->get('search')['value'].'%')
            // ->orWhere('phone_number', 'LIKE', '%'.request()->get('search')['value'].'%');
            }


        }
        if (request()->filled('status_id')) {
            $query->filterByStatus(request('status_id'));
        }
        if (request()->filled('paymet_status')) {
            $query->filterByPaymentStatus(request('paymet_status'));
        }
        if (request()->filled('batch')) {
            $query->filterByBatch(request('batch'));
        }
        if (request()->filled('student')) {
            $query->filterByStudent(request('student'));
        }
        if (request()->filled('fee_type')) {
            $query->filterByFeeType(request('fee_type'));
        }
        if (request()->filled('month')) {
            $query->filterByMonth(request('month'));
        }
        if (request()->filled('location_id')) {
            $query->filterByLocation(request('location_id'));
        }
        
         
        // if (request()->has('role') && request('role') != "") {
        //     $query->whereHas('roles', function ($q) {
        //         $q->where('id', request('role'));
        //     });
        // }
    }
    public function scopeFilterByStudent(Builder $query, $user_id): Builder
    {
        return   $query->where('user_id', $user_id);
    } 
    public function scopeFilterByMonth(Builder $query, $month): Builder
    {
        return $query->whereHas('installments', function ($query) use ($month) {
            $query->whereMonth('created_at', $month);
         });
    }
    public function scopeFilterByFeeType(Builder $query, $fee_type): Builder
    {
        return   $query->where('fee_type', $fee_type);
    } 
    public function scopeFilterByLocation(Builder $query, $location_id): Builder
    {
        return   $query->where('location_id', $location_id);
    } 
    public function scopeBranchWise(Builder $query)
    {
        if(auth()->user()->location_id !=null){
            return $query->filterByLocation(auth()->user()->location_id);
        }
        return $query;
    }
    public function scopeFilterByBatch(Builder $query, $batch_id): Builder
    {
        return $query->whereHas('user', function ($query) use ($batch_id) {
            $query->whereIn('id' , function ($query) use ($batch_id) {
                $query->select('user_id')
                ->from('batch_students')
                ->where('batch_id', '=', $batch_id );
            });
         });
       
    } 
    public function scopeFilterByName(Builder $query, $text): Builder
    {
        // $nameToFilter = '%'.$text.'%';
        return $query->whereHas('user', function ($query) use ($text) {
            $query->where('first_name', 'like', '%' . $text . '%')
            ->orWhere('last_name', 'like', '%' . $text . '%');
        })
        ->with('user');
    } 
    public function scopeFilterByPaymentStatus(Builder $query, $status): Builder
    {
        return $query->whereHas('installments', function ($query) use ($status) {
            $query->where('status_id', $status);
         })
        ->with('user');
    } 
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function list()
    {
        return [ self::YEARLY =>  "Yearly" ,  self::HALF_YEARLY =>  'Half Yearly' ,  self::MONTHLY => 'Monthly' , self::QUARTERLY => 'Quarterly' ];
    }
    public function installments()
    {
        return $this->hasMany(FeeLog::class, 'fee_id');
    }
    public function unpaidAmount()
    {
        return $this->installments()->where('status_id', STATUS::STATUS_UNPAID)->sum('amount');
    }
    public function newpayment()
    {
        return $this->hasOne(FeeLog::class, 'fee_id')->where('status_id', STATUS::STATUS_UNPAID);
    }
    public function scopePaid(Builder $query)
    {
        return $query->where('status_id', STATUS::STATUS_PAID );
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class,'creator_id');
    }
    public function scopeUser(Builder $query)
    {
        return $query->where('user_id', auth()->user()->id  );
    }
     // Define the relationship with the Location model
     public function location()
     {
         return $this->belongsTo(Location::class, 'location_id');
     }
}
