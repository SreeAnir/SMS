<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\HasStatus;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;


class StaffPayment extends Model
{
    use HasFactory, SoftDeletes,HasStatus,HasRoles;


    protected $fillable = ['user_id','basic_salary','hra','other_allowance','note','location_id'];

    public const PERMISSION_STAFF_PAYMENT_LIST = 'List Staff payments';
    public const PERMISSION_STAFF_PAYMENT_VIEW = 'View Staff payment';
    public const PERMISSION_STAFF_PAYMENT_UPDATE = 'Update Staff payments';
    public const PERMISSION_STAFF_PAYMENT_CREATE = 'Create Staff payments';
    public const PERMISSION_STAFF_PAYMENT_DELETE = 'Delete Staff payments';
    
    public function scopeFilterFromRequest(Builder $query)
    {
        if (request()->filled('search')) {
            if(request()->get('search')['value']!=null){
            $query->filterByNameOrMail(request()->get('search')['value']);
            }
        }
        if (request()->filled('created_at')) {
            $query->filterByDate(request('created_at'));
        }else if (request()->filled('month')) {
            $query->filterByMonth(request('month'));
        }
        if (request()->filled('staff_id')) {
            if(request()->get('staff_id')!=null){
            $query->filterByStaff(request()->get('staff_id'));
            }
        }
        if (request()->filled('location_id')) {
            if(request()->get('location_id')!=null){
            $query->filterByLocation(request()->get('location_id'));
            }
        }
    }
    public function scopeFilterByLocation(Builder $query, $location_id): Builder
    {
        return   $query->where('location_id', $location_id);
    } 
    public function scopeFilterByNameOrMail(Builder $query, $text): Builder
    {
        $search_text = '%'.$text.'%';
        return $query->whereHas('user', function ($subQuery) use( $search_text){
                $subQuery->where('first_name', 'LIKE', $search_text)
                ->orWhere('last_name', 'LIKE', $search_text)
                ->orWhere('email', 'LIKE', '%'.request()->get('search')['value'].'%')
                ->orWhere('phone_number', 'LIKE', '%'.request()->get('search')['value'].'%');
        });
    } 
    public function scopeFilterByDate(Builder $query, $date): Builder
    {
        return $query->whereDate('created_at', $date);
    } 
    public function scopeFilterByMonth(Builder $query, $month): Builder
    {
        return $query->whereMonth('created_at', $month);
    } 
    public function scopeFilterByStaff(Builder $query, $staff_id): Builder
    {
        return $query->where('user_id', $staff_id);
    } 

    

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getNetPayAttribute()
    {
        return $this->basic_salary + $this->hra + $this->other_allowance;
    }
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
