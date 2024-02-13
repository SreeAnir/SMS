<?php

namespace App\Listeners;

use App\Notifications\WelcomeEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\AdminNewUser;

class AdminWelcomeMailListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AdminNewUser $event): void
    {
        $user = $event->data;
        $user->notify(new WelcomeEmail());
    }
}

 
