<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NotificationUser ;
use Exception;
class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{  
            // with(['notification' => function($query) use ( $notification_type ){
            //     $query->where('notification_type', $notification_type );
            // }])->
            $notification_type = ( $request->notification_type == null ? 1 : $request->notification_type  ) ;
            // $notification_listing = NotificationUser::whereHas(['notification' => function($query) use ( $notification_type ){
            //     $query->where('notification_type', $notification_type );
            //     }])->where('user_id' , auth()->user()->id )->paginate( 20 ); 
            $notification_listing = NotificationUser::whereHas('notification', function ($query) use ($notification_type) {
                $query->where('notification_type', $notification_type);
            })->where('user_id', auth()->id())->paginate(20);
            $not_htm = view('student.notification',compact('notification_listing'))->render();
            return response()->json(['status' => "success", 'html' => $not_htm , 'message' => "Notification Details" ], 200);
        } catch (Exception $e) {

            return response()->json(['status' => "success", 'html' => "Failed to process" , 'message' =>  $e->getLine().$e->getMessage() ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
