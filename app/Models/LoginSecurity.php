<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginSecurity extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','google2fa_enable','updated_at'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
