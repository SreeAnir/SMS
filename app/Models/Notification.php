<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\HasStatus;
use Spatie\Permission\Traits\HasRoles;

class Notification extends Model
{
    use HasFactory,HasStatus,HasRoles;

    public const PERMISSION_NOTIFICATION_LIST = 'List Notification';
    public const PERMISSION_NOTIFICATION_VIEW = 'View  Notification';
    public const PERMISSION_NOTIFICATION_UPDATE = 'Update Notification';
    public const PERMISSION_NOTIFICATION_CREATE = 'Create Notification';
    public const PERMISSION_NOTIFICATION_DELETE = 'Delete Notification';


    const GENERAL            = 1;
    const EVENT              = 2;

    protected $fillable = [
        'title', 'message', 'notification_type', 'status_id', 'notification_date', 'schedule_later', 'deleted','event_id'
    ];

    public static function list()
    {
        return [self::GENERAL=>  "General" ,  self::EVENT =>  'Event' ];
    }

    // public static function getNotificationLabelAttribute()
    // {
    // if($this->notification_type ==  self::EVENT ){
    //     return "Event";
    //    }else{
    //     return "General";
    //    }
    // }
    
     public function getNotificationTypeLabelAttribute()
     {
         $notificationType = $this->attributes['notification_type'];
         return ($notificationType == self::EVENT ? "Event" :  "General"   );
     }
    public function users()
    {
        return $this->hasMany(NotificationUser::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function notifiable()
    {
        return $this->morphTo();
    }

     
    public function scopeFilterFromRequest(Builder $query)
    {
        if (request()->filled('search')) {
            if(request()->get('search')['value']!=null){
            $query->filterBySearchText(request()->get('search')['value']);
            }
        }
        if (request()->filled('created_at')) {
            $query->filterByDate(request('created_at'));
        }else if (request()->filled('month')) {
            $query->filterByMonth(request('month'));
        }
    }
    public function scopeFilterByDate(Builder $query, $date): Builder
    {
        return $query->whereDate('event_date', $date);
    } 
    public function scopeFilterByMonth(Builder $query, $month): Builder
    {
        return $query->whereMonth('event_date', $month);
    } 
    public function scopeFilterBySearchText(Builder $query, $text): Builder
    {
        $search_text = '%'.$text.'%';
        return $query->where('title', 'LIKE', $search_text)
                ->orWhere('description', 'LIKE', $search_text);
    } 
    public function scopeFilter(Builder $query)
    {
        if (request()->filled('notification_type')) {
            $query->filterByType(request('notification_type'));
        }
        return $query ;
    }
    public function scopeFilterByType(Builder $query, $type): Builder
    {
        return $query->where('notification_type' , $type);
    } 
}
