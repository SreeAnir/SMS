<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kacha extends Model
{
    use HasFactory;
    
    public function students()
    {
        return $this->belongsToMany(Student::class, 'kacha_students');
    }
}
