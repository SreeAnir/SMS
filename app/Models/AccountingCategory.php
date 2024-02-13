<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Accounting;
use App\Traits\Constant;
use Spatie\Permission\Traits\HasRoles;

class AccountingCategory extends Model
{
    use HasFactory,SoftDeletes,HasStatus,Constant,HasRoles;
    protected $guarded = ['id']; 

   

    public const PERMISSION_CATEGORY_LIST = 'List Categories';
    public const PERMISSION_CATEGORY_VIEW = 'View Category';
    public const PERMISSION_CATEGORY_UPDATE = 'Update Category';
    public const PERMISSION_CATEGORY_CREATE = 'Create Category';
    public const PERMISSION_CATEGORY_DELETE = 'Delete Category';

    public function getCategoryTypeLabelAttribute()
    {
        return  ($this->category_type == self::INCOME ? "Income" : "Expense");
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
         
    }
    public function scopeFilterByStudent(Builder $query, $user_id): Builder
    {
        return   $query->where('category_label', 'LIKE', '%'.request()->get('search')['value'].'%');
    } 
    public function accountings()
    {
        return $this->hasMany(Accounting::class,'category_id');
    }
}
