<?php

namespace App\Traits;

use App\Models\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

trait HasStatus
{
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('status_id', Status::STATUS_ACTIVE);
    }
    public function scopeUnpaid(Builder $query)
    {
        return $query->where('status_id', Status::STATUS_UNPAID);
    }

    public function scopeFilterByStatus(Builder $query, $status)
    {
        if (in_array(SoftDeletes::class, class_uses($this))) {
            $query->withoutTrashed();
        }
        return $query->where('status_id', $status instanceof Status ? $status->id : $status);
    }
    
}