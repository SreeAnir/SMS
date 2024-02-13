<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\HasStatus;

use Spatie\Permission\Models\Permission;

class BatchStudent extends Authenticatable
{
    use HasStatus;
    // Define the table name explicitly
    // protected $table = 'batches';

    // Define fillable columns
    protected $fillable = [
        'student_id',
        'batch_id'
    ];

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
        
         
        // if (request()->has('role') && request('role') != "") {
        //     $query->whereHas('roles', function ($q) {
        //         $q->where('id', request('role'));
        //     });
        // }
    }
    public function scopeFilterByName(Builder $query, $text): Builder
    {
        // $nameToFilter = '%'.$text.'%';
        return $query->whereHas('student.user', function ($query) use ($text) {
            $query->where('first_name', 'like', '%' . $text . '%')
            ->orWhere('last_name', 'like', '%' . $text . '%');
        });
    } 
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }
    
    public function scopeBranchWise(Builder $query)
    {
        if(auth()->user()->location_id !=null){
            return $query->filterByLocation(auth()->user()->location_id);
        }
        return $query;
    }
    // public function scopeFilterByLocation(Builder $query, $location_id): Builder
    // {
    //     return $query->whereHas('student.user', function ($query) use ($location_id) {
    //         $query->where('location_id',  $location_id ) ;
    //     });
    // } 
}

