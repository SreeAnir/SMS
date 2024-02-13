<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\NotificationUser;

use App\Models\Notification as NotificationModel;
use App\Mail\StudentNotificationMail ;
class StudentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $notification;

     /**
     * Create a new notification instance.
     */
    public function __construct ( NotificationModel $not = null)
    {
        $this->notification = $not;
         
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
        // if( $this->notification->notification_type != NotificationModel::EVENT){

        // }
        return (new StudentNotificationMail( $this->notification, $notifiable ))->to($notifiable->email);

        //  return (new MailMessage)
        //             ->line('The introduction to the notification.')
        //             ->action('Notification Action', url('/'))
        //             ->line('Thank you for using our application!');
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
