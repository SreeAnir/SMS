<?php

namespace App\Mail;

use App\Models\Status;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Notification;
use App\Models\NotificationUser;

use Exception;
use Illuminate\Support\Facades\Log;

class StudentNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $notification ;
    public $user;
    public  $title;
    /**
     * Create a new message instance.
     */
    public function __construct(Notification $notification , $user)
    {
       $this->notification =  $notification ;
       $this->user =  $user ;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        // if($this->notification->notification_type == Notification::EVENT ) {
        //     $this->title = $this->notification->event->title;
        // } else {
        //     $this->title = $this->notification->title;
        // }
        $this->title = $this->notification->title;
        return new Envelope(
            subject: $this->title ." - Your Exclusive Invitation Inside!"
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        try {

             $mail =  new Content(view: 'mail.general-notification', with: [ 'title' => $this->title , 'notification' => $this->notification, 'user' => $this->user]);
             NotificationUser::where(["user_id" => $this->user->id , "notification_id" => $this->notification->id ])->update(["status_id" =>  Status::STATUS_SENT]);
             Notification::where([  "id" => $this->notification->id ])->update(["status_id" =>  Status::STATUS_SENT ]);
             return $mail ;
        } catch (\Exception $e) {
            // Handle the exception here, you can log it or perform any necessary actions
            // For example, log the exception and return a default Content object or rethrow the exception
            Log::error('Exception in content(): ' . $e->getMessage());
            // You can return a default Content object or rethrow the exception
            // return new Content(view: 'mail.default-content');
            throw $e;
        }
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
