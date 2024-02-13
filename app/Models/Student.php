<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasStatus;
use App\Models\Status;
class Student extends Model
{
    use HasStatus;
    protected $table = 'students';


    public const PERMISSION_STUDENT_LIST = 'List Students';
    public const PERMISSION_STUDENT_VIEW = 'View Students';
    public const PERMISSION_STUDENT_UPDATE = 'Update Students';
    public const PERMISSION_STUDENT_CREATE = 'Create Students';
    public const PERMISSION_STUDENT_DELETE = 'Delete Students';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id']; 

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function batches()
    {
        return $this->belongsToMany(Batch::class, 'batch_students', 'student_id', 'batch_id');
    }
    public function batch()
    {
        return $this->batches()->where('status_id', Status::STATUS_ACTIVE);
    }
    public function allbatch()
    {
        return $this->batches();
    }
    public function scopeBranchWise(Builder $query)
    {
        if(auth()->user()->location_id !=null){
            return $query->filterByLocation(auth()->user()->location_id);
        }
        return $query;
    }
    public function scopeFilterByLocation(Builder $query, $text): Builder
    {
        // $nameToFilter = '%'.$text.'%';
        return $query->whereHas('user.location', function ($query) use ($text) {
            $query->where('location_id',  auth()->user()->location_id);
        });
    } 
    // public function scopeFilterByKacha(Builder $query, $kacha): Builder
    // {
    //     // $nameToFilter = '%'.$text.'%';
    //     return $query->whereHas('user.location', function ($query) use ($kacha) {
    //         $query->where('location_id',  auth()->user()->location_id);
    //     });
    // } 
    
    public function kacha()
    {
        return $this->belongsTo(Kacha::class);
    }
    public function kachas()
    {
        return $this->belongsToMany(Kacha::class, 'kacha_students');
    }
    public function kachaStudents()
    {
        return $this->hasMany(KachaStudent::class);
    }
}
