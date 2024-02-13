<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdminNewUser
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $data ;

    /**
     * Create a new event instance.
     */
    public function __construct($user)
    {
        $this->data = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    // public function broadcastOn(): array
    // {
    //     return [
    //         new PrivateChannel('channel-name'),
    //     ];
    // }
}

// <?php

// namespace App\Events;

// use Illuminate\Broadcasting\Channel;
// use Illuminate\Broadcasting\InteractsWithSockets;
// use Illuminate\Broadcasting\PresenceChannel;
// use Illuminate\Broadcasting\PrivateChannel;
// use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
// use Illuminate\Foundation\Events\Dispatchable;
// use Illuminate\Queue\SerializesModels;
// use Illuminate\Support\Facades\Log;

// class GenerateCertificate
// {
//     use Dispatchable, InteractsWithSockets, SerializesModels;

//     public $data ;
//     /**
//      * Create a new event instance.
//      *
//      * @return void
//      */
//     public function __construct($course_user)
//     {
//         $this->data = $course_user;
//     }

//     /**
//      * Get the channels the event should broadcast on.
//      *
//      * @return \Illuminate\Broadcasting\Channel|array
//      */
//     // public function broadcastOn()
//     // {
//     //     return new PrivateChannel('channel-name');
//     // }
// }

