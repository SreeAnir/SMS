<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\NotificationUser;

use App\Models\FeeLog ;
use App\Mail\StudentFeeReminderMail ;
class StudentFeeReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public $installment ;

     /**
     * Create a new notification instance.
     */
    public function __construct ( FeeLog $installment = null)
    {
        $this->installment = $installment ;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable)
    { 
        $user = $this->installment->fee->user ;
        $batch = $user->student->batch; 
        if( $batch->count() > 0){
            $subject =   'Payment Reminder - '.env('APP_NAME').'  Batch '. @$batch[0]->batch_name .', '.@$batch[0]->location->name ;
          }else{
            $subject =   'Payment Receipt and Acknowledgment - '.env('APP_NAME') ;
          }
        return (new StudentFeeReminderMail( $this->installment, $subject ))->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
