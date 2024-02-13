<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Status extends Model  
{
    use SoftDeletes;

    const STATUS_ACTIVE                = 1;
    const STATUS_INACTIVE              = 2;
    const STATUS_PENDING               = 3;
    const STATUS_EXPIRED               = 4;
    const STATUS_DRAFT                 = 5;
    const STATUS_PUBLISHED             = 6;
    const STATUS_SENT                  = 7;
    const STATUS_NOT_SENT                  = 8;
    const STATUS_SENDING                  = 9 ;

    const STATUS_UNPAID                  = 10 ;
    const STATUS_PAID                  = 11 ;
    const STATUS_PENDIN_PAYMENT                  = 12 ;

    
    /** ==================== Statics ==================== */

    public static function list($withTrashed = false, $withInactive = false){
    $cacheKey = 'status_list_' . (int)$withTrashed . '_' . (int)$withInactive;

    return Cache::remember($cacheKey, now()->addMinutes(60), function () use ($withTrashed, $withInactive) {
        $statuses = static::whereIn('id', [
            self::STATUS_ACTIVE,
            self::STATUS_INACTIVE,
            self::STATUS_PENDING,
        ])->get();

        if (Auth::user()->hasRole(Role::ROLE_SUPER_ADMIN) && $withTrashed) {
            $trashedStatus = new Status([
                "id" => 0,
                "status" => __('Trashed'),
            ]);
            $statuses->push($trashedStatus);
        }

        return $statuses;
    });
}

    // public static function list($withTrashed = false, $withInactive = false) {
    //     $statuses = static::whereIn('id', [
    //         self::STATUS_ACTIVE,
    //         self::STATUS_INACTIVE,
    //         self::STATUS_PENDING,
    //     ])->get();
    //     if(Auth::user()->hasRole(Role::ROLE_SUPER_ADMIN)) {
    //         if($withTrashed) {
    //             $TrashedStatus = new Status([
    //                 "id"     => 0,
    //                 "status" => __('Trashed')
    //             ]);
    //             $statuses->push($TrashedStatus);
    //         }
    //     }
    //     return $statuses;
    // }
     /** ==================== Statics ==================== */
     public static function notficationStatuslist($withTrashed = false, $withInactive = false) {
        $statuses = static::whereIn('id', [
            self::STATUS_DRAFT,
            self::STATUS_PUBLISHED,
            self::STATUS_SENT,
        ])->get();
        if(Auth::user()->hasRole(Role::ROLE_SUPER_ADMIN)) {
            if($withTrashed) {
                $TrashedStatus = new Status([
                    "id"     => 0,
                    "status" => __('Trashed')
                ]);
                $statuses->push($TrashedStatus);
            }
        }
        return $statuses;
    }
    public static function paymentStatuslist($withTrashed = false, $withInactive = false) {
        $statuses = static::whereIn('id', [
            self::STATUS_UNPAID,
            self::STATUS_PENDIN_PAYMENT,
            self::STATUS_PAID,
        ])->get();
        if(Auth::user()->hasRole(Role::ROLE_SUPER_ADMIN)) {
            if($withTrashed) {
                $TrashedStatus = new Status([
                    "id"     => 0,
                    "status" => __('Trashed')
                ]);
                $statuses->push($TrashedStatus);
            }
        }
        return $statuses;
    }
    
}
