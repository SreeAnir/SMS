<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Notification;
use App\DataTables\NotificationTable ;
use App\Http\Requests\NotificationRequest;
use App\Models\Status;
use Illuminate\Support\Facades\DB;
use App\Models\User ;
use App\Notifications\StudentNotification;
use App\Models\NotificationUser;
class NotificationController extends Controller
{
    public function __construct()
    {
         $this->authorizeResource(Notification::class, 'notification');
    }
     /**
     * Display a listing of the resource.
     */
    public function index(NotificationTable $dataTable)
    {
        try {
            return $dataTable->render("admin.notifications.index");
        }catch (Exception $e) {  
            dd($e->getMessage() );
            $response = ['status' => 'error', 'message' =>  $e->getMessage() ];
            return redirect()->back()->with($response);
        } 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $events = Event::get();
        return view('admin.notifications.create', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NotificationRequest $request)
    {
        try{
            DB::beginTransaction();

            $notificationData = $request->getData();
            // If there's an associated event, link it
            if ($request->has('event_id') && $request->event_id !=null) {
                $event = Event::findOrFail($request->input('event_id'));
                $notification = $event->notifications()->create($notificationData); 
            } else {
                $notification = Notification::create($notificationData);
            }
            $this->checkAndSendNotification($request->users,$notification);
            DB::commit();
            // return redirect()->route('notifications.show',   'Notification created successfully.' ) ;
            $response = ['status' => 'success', 'message' => 'Notification created successfully!'];
            return redirect()->route('notifications.show', $notification )->with($response);
            // return redirect()->back()->with('success', 'Notification created successfully.');
        }  catch (Exception $e) {
            DB::rollback();
            $response = ['status' => 'error', 'message' => $e->getMessage()];
            return redirect()->back()->with($response);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        return view('admin.notifications.show', compact('notification'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notification $notification)
    { 
        $events = Event::get();

        return view('admin.notifications.edit', compact('notification','events'));

    }

   
      /**
     * Store a newly created resource in storage.
     */
    public function update(NotificationRequest $request,Notification $notification)
    {
        try {
            DB::beginTransaction();
            $notificationData = $request->getData();

            if ($not = $notification->update($notificationData)) {
                DB::commit();
                $this->checkAndSendNotification($request->users , $notification);
                $response = ['status' => 'success', 'message' => 'Notification updated successfully!'];
                return redirect()->route('notifications.show', $notification)->with($response);
            }

            $response = ['status' => 'error', 'message' => 'Failed to update Notification!'];
            return redirect()->back()->with($response);

        } catch (Exception $e) {
            DB::rollback();
            $response = ['status' => 'error', 'message' => $e->getMessage()];
            return redirect()->back()->with($response);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    private function checkAndSendNotification($users, $notification ){  
        $userList = User::whereIn('id',$users)->get();
        foreach ($userList as $user) {
            // $user = ($userId === 'all') ? 'all' :$userId;
            // if($userId != 'all'){
                $notification->users()->updateOrCreate(
                    ['user_id' => $user->id ],
                    ['status_id' => Status::STATUS_NOT_SENT]
                );
                // if($notification->status_id == Status::STATUS_PUBLISHED){
                //     if( !$notification->schedule_later ){
                         $user->notify(new StudentNotification( $notification));
                         NotificationUser::where(["user_id" => $user->id , "notification_id" => $notification->id ])->update(["status_id" =>  Status::STATUS_SENDING]);
                         Notification::where([  "id" => $notification->id ])->update(["status_id" =>  Status::STATUS_SENDING]);

                         // }
                // }
                // $notification->users()->create(['user_id' => $userId , 'status_id' => Status::STATUS_NOT_SENT ]);
            // }
         }
        
    }
}
