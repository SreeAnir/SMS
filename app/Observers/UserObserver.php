<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Role;
use App\Models\Status;
use Illuminate\Support\Str;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        if($user->user_type == Role::USER_TYPE_STUDENT  &&  $user->status_id == Status::STATUS_ACTIVE){
            $user->ID_number = 'kc' . str_pad($user->id, 4, '0', STR_PAD_LEFT);
            $user->user_name = 'skc' . strtoupper( Str::random(2).$user->user_id ) ;
            $user->save();
        }
    }
    
    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
