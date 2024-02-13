<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FeePaymentMail extends Mailable
{
    use Queueable, SerializesModels;
    public $feeLog;
    public $status;

    /**
     * Create a new message instance.
     */
    public function __construct($feeLog , $status )
    {
        $this->feeLog = $feeLog;
        $this->status = $status;
        

        

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Payment Update"  ,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.student-payment-update', with: [ 'user' => auth()->user(),'feeLog' =>$this->feeLog , $this->status],
        );
        
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
