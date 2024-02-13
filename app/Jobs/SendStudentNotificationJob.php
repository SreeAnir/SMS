<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
// use App\Mail\StudentNotificationMail;
use App\Models\User;
use App\Models\NotificationUser;
use App\Models\Notification;
use App\Notifications\StudentNotification;
use App\Models\Status;
use Carbon\Carbon;
class SendStudentNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    // $this->dispatch((new SendEmailJob($user))->delay(now()->addSeconds(5)));

    public function handle()
    {
        $notifications = Notification::whereDate('notification_date', Carbon::today())->whereIn('status_id' , [ Status::STATUS_PUBLISHED ,Status::STATUS_NOT_SENT  ])->get();
        
        if($notifications->count() > 0 ){ 
            foreach ($notifications as $notification) {
            $userList =  $notification->users;  
            foreach ($userList as $not_user) {
                $user = $not_user->user;
                    $user->notify(new StudentNotification( $notification));
                    //->delay(now()->addSeconds(5));
                    NotificationUser::where(["user_id" => $user->id , "notification_id" => $notification->id ])->update(["status_id" =>  Status::STATUS_SENDING]);
                    Notification::where([  "id" => $notification->id ])->update(["status_id" =>  Status::STATUS_SENDING]);

            }
        }
        }
        
    }
}
