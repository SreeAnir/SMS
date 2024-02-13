<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\AccountingCategory;
use App\Traits\Constant;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Accounting extends Model
{
    use HasFactory,Constant,SoftDeletes,HasRoles;
    protected $guarded = ['id']; 

    public const PERMISSION_ACCOUNTING_LIST = 'List  Income & Expense';
    public const PERMISSION_ACCOUNTING_VIEW = 'View  Income & Expense';
    public const PERMISSION_ACCOUNTING_UPDATE = 'Update  Income & Expense';
    public const PERMISSION_ACCOUNTING_CREATE = 'Create  Income & Expense';
    public const PERMISSION_ACCOUNTING_DELETE = 'Delete Income & Expense';

    public function getCategoryTypeLabelAttribute()
    {
        return  ($this->category_type == self::INCOME ? "Income" : "Expense");
    }
    
    public function scopeBranchWise(Builder $query)
    {
        if(auth()->user()->location_id !=null){
            return $query->filterByLocation(auth()->user()->location_id);
        }
        return $query;
    }
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
        if (request()->filled('category_id')) {
            $query->filterByCategory(request('category_id'));
        }
        if (request()->filled('date_from') && request()->filled('date_to')) {
            $query->filterByDateRange(request('date_from'), request('date_to'));
        }
        if (request()->filled('month')) {
            $query->filterByMonth(request('month'));
        }
        if (request()->filled('income') && request()->filled('expense') ) {
            if( request()->get('income')  === 'false' && request()->get('expense')  === 'false' ){ 
                $query->filterByAccType([  self::EXPENSE , self::INCOME]);
            }
            elseif(request()->get('income')  === 'false' ){ 
                $query->filterByAccType([ self::EXPENSE ]);
            }else if(request()->get('expense')  === 'false' ){
                $query->filterByAccType([  self::INCOME]);
            }
          
            else{
                $query->filterByAccType([  self::EXPENSE , self::INCOME]);
            }
        }
        if(request()->get('location_id')  ){
            $query->filterByLocation( request('location_id') );
        }
         
    }
    public function scopeFilterByLocation(Builder $query, $location_id): Builder
    {  
        return   $query->where('location_id', $location_id);
    }
    public function scopeFilterByCategory(Builder $query, $category_id): Builder
    {
        return   $query->where('category_id', $category_id);
    }
    public function scopeFilterByName(Builder $query, $amount): Builder
    {
        return   $query->where('amount', $amount);
    }
    public function scopeFilterByDate(Builder $query, $date): Builder
    {
        return $query->whereDate('date', $date);

    }
    public function scopeFilterByDateRange(Builder $query, $from , $to ): Builder
    {
        return $query->whereBetween('date', [$from, $to]);

    }
    public function scopeFilterByAccType(Builder $query, $acc_type): Builder
    {
        return   $query->whereIn('acc_type', $acc_type);
    }
    public function scopeFilterByMonth(Builder $query, $month): Builder
    {
        return $query->whereMonth('date', $month);
    }
    public function category()
    {
        return $this->belongsTo(AccountingCategory::class);
    }
    public function scopeIncomeData(Builder $query)
    {
        return $query->where('acc_type',  self::INCOME);
    }
    public function scopeExpenseData(Builder $query)
    {
        return $query->where('acc_type',  self::EXPENSE);
    }
     public function location()
     {
         return $this->belongsTo(Location::class, 'location_id');
     }
}
