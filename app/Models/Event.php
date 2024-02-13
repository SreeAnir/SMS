<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\HasStatus;
use Carbon\Carbon;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Status;

class Event extends Model
{
    use HasFactory,HasStatus,HasRoles;

    protected $fillable = ['title','description','event_date','event_time','address','visibility','status_id'];

    public const PERMISSION_EVENT_LIST = 'List Events';
    public const PERMISSION_EVENT_VIEW = 'View Event';
    public const PERMISSION_EVENT_UPDATE = 'Update Event';
    public const PERMISSION_EVENT_CREATE = 'Create Event';
    public const PERMISSION_EVENT_DELETE = 'Delete Event';

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
    public function getEventTimeAttribute($value)
    {
        return Carbon::parse($value)->format('h:i A');
    }
    public function notifications()
    {
        return $this->morphOne(Notification::class, 'notifiable');
    }
    public function scopeAvailable(Builder $query)
    {
        return $query->where('status_id', Status::STATUS_PUBLISHED );
    }
    public function scopeFilter(Builder $query)
    {
        if (request()->filled('filter_event')) {
            $query->filterByEvent(request('filter_event'));
        }
        return $query ;
    }
    public function scopeFilterByEvent(Builder $query, $type): Builder
    {
        $date = Carbon::now();
        if( $type == 1){
            return $query->whereDate('event_date','>=', $date);
        }else if($type == 2 ){
            return $query->whereDate('event_date','<', $date);
        }
        return $query ;
    } 
}
