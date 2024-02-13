<?php 
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class StudentApprovedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $plain_password;

    public function __construct($user,$plain_password)
    {
        $this->user = $user;
        $this->plain_password = $plain_password;
        // dd($plain_password);
    }

    public function build()
    {
        return $this->view('mail.student_approved')
                    ->subject('Approval Success')
                    ->with([
                        'user' => $this->user,
                        'plain_password' =>$this->plain_password
                    ]);
    }
}
