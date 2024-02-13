<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Exception;


class EventController extends Controller
{ 

    public function index(Request $request)
    {
        try{  
            $event_list = Event::filter()->available()->paginate( 20 );
            $event_html = view('student.event',compact('event_list'))->render();
            return response()->json(['status' => "success", 'html' => $event_html , 'message' => "kdfj" ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => "success", 'html' => "Failed to process" , 'message' =>  $e->getMessage() ], 500);
        }
    }

}
