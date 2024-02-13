<?php 
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeEmail extends Mailable
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
        return $this->view('mail.welcome_email')
                    ->subject('Welcome to Our'.env('APP_NAME'))
                    ->with([
                        'user' => $this->user,
                        'plain_password' =>$this->plain_password
                    ]);
    }
}
