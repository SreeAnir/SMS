<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KachaStudent extends Model
{
    use HasFactory;
    protected $guarded = ['id']; 

    // Relationship with the Student model
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Relationship with the Kacha model
    public function kacha()
    {
        return $this->belongsTo(Kacha::class, 'kacha_id');
    }

}
