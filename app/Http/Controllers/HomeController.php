<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\NotificationUser;
use App\Models\Fee;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    { 
        $notifications = [];
        $notification_list = NotificationUser::with(['notification'])->userNotification()->get();
        $fee_list = Fee::with(['installments'])->user()->get();
        // $new_payment = User::with(['newpayment'])->user()->newpayment()->first();
        $user_id  = auth()->user()->id ;
        $new_payment = Fee::with(['newpayment' => function ($query) {
            $query->orderBy('payment_due_date', 'asc');
        }])->active()->where('user_id', $user_id)->first();
        return view('home',compact('notifications','notification_list','fee_list','new_payment'));
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function eventSummary()
    { 
        return view('home');
    }
    
}
