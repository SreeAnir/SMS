<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Builder;

class NotificationUser extends Model
{
    use HasFactory,HasStatus;
    protected $fillable = [
        'notification_id', 'user_id', 'status_id', 'deleted'
    ];

    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
  
    public function scopeUserNotification(Builder $query)
    {
        return $query->where('user_id', auth()->user()->id );
    }
   
}
