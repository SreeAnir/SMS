<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class TestController extends Controller
{ 

    public function testspeed()
    {
        return view('test/speed');
    }
    public function testEmail($id = 0)
    {

        $subject  = "Test";
        $to_name = "Sreekala";
        $to_email = "sreekalaanirudhan1020@gmail.com";
        $data = array();


 
        $to_name = "Sreekala";
        $to_email = "sreekalaanirudhan1020@gmail.com";
        $subject  = "test";
        $mail = Mail::send('mail.test', $data, function ($message) use ($to_name, $to_email, $subject) {
            $message->to($to_email, $to_name)
                ->subject($subject);
            $message->from(env('MAIL_FROM_ADDRESS'),  env('APP_NAME'));
        });
        return true;
    }

}
