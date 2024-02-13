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

class Batch extends Authenticatable
{
    use HasStatus,HasRoles,SoftDeletes;
    // Define the table name explicitly
    protected $table = 'batches';

    public const PERMISSION_BATCH_LIST = 'List Batch';
    public const PERMISSION_BATCH_VIEW = 'View Batch';
    public const PERMISSION_BATCH_UPDATE = 'Update Batch';
    public const PERMISSION_BATCH_CREATE = 'Create Batch';
    public const PERMISSION_BATCH_DELETE = 'Delete Batch';

    // Define fillable columns
    protected $guarded = ['id']; 

    // Define the relationship with the Location model
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
    
    // public function students()
    // {
    //     return $this->belongsToMany(Student::class, 'batch_students', 'batch_id', 'student_id');
    // }
    public function students()
    {
        return $this->belongsToMany(Student::class, 'batch_students');
    }
    
    public function scopeFilterFromRequest(Builder $query)
    {
        if (request()->filled('search')) {
            if(request()->get('search')['value']!=null){
                $search_text = '%'. request()->get('search')['value'].'%';
                return $query->where('batch_name', 'LIKE', $search_text)
                ->orWhere('batch_time', 'LIKE', $search_text);
            }
        }
        
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
}

