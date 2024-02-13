<?php

namespace App\Notifications;

use App\Mail\UserCreatedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserCreated extends Notification
{
    use Queueable;
    public $user;
    public $passwrod_text ;
    /**
     * Create a new notification instance.
     */
    public function __construct($user, $passwrod_text)
    {
        $this->user = $user ;
        $this->passwrod_text = $passwrod_text ;
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
       
    return (new UserCreatedMail($this->user ,$this->passwrod_text))->to($notifiable->email);

        // return (new MailMessage)
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
