<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Http\Requests\EventRequest ;
use Illuminate\Support\Facades\DB;
use App\DataTables\EventDataTable ;

use Exception;
class EventController extends Controller
{
    public function __construct()
    {
         $this->authorizeResource(Event::class, 'event');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(EventDataTable $dataTable)
    {
        try {
            return $dataTable->render("admin.events.index");
        }catch (Exception $e) {  
            $response = ['status' => 'error', 'message' =>  $e->getMessage() ];
            return redirect()->back()->with($response);
        } 
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }
     /**
     * Store a newly created resource in storage.
     */
    public function store(EventRequest $request)
    {
        try {
            DB::beginTransaction();
            $eventData = $request->getData();

            if ($event = Event::create($eventData)) {
                DB::commit();
                $response = ['status' => 'success', 'message' => 'Event created successfully!'];
                return redirect()->route('events.show', $event)->with($response);
            }

            $response = ['status' => 'error', 'message' => 'Failed to create the Event!'];
            return redirect()->back()->with($response);

        } catch (Exception $e) {
            DB::rollback();
            $response = ['status' => 'error', 'message' => $e->getMessage()];
            return redirect()->back()->with($response);
        }
    }
   /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    
      /**
     * Store a newly created resource in storage.
     */
    public function update(EventRequest $request,Event $event)
    {
        try {
            DB::beginTransaction();
            $eventData = $request->getData();
            if ($eventsave =$event->update($eventData)) {
                DB::commit();
                $response = ['status' => 'success', 'message' => 'Event updated successfully!'];
                return redirect()->route('events.show', $event)->with($response);
            }

            $response = ['status' => 'error', 'message' => 'Failed to update the event!'];
            return redirect()->back()->with($response);

        } catch (Exception $e) {
            DB::rollback();
            $response = ['status' => 'error', 'message' => $e->getMessage()];
            return redirect()->back()->with($response);
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function showCalendar()
    {
        $events = Event::select('title','id',DB::raw('`event_date` as start,`event_date` as end'))->get();
        return view('admin.events.calendar',compact('events'));
    }
    public function getEventInfo(Request $request)
    {
        try{
            $event = Event::select('title','id','event_date', 'event_time','description')->findOrFail($request->event_id);
            $msg ="We are thrilled to announce the upcoming ". $event->title.", a gathering that promises to be nothing short of  spectacular. As a valued member of our community, we extend an exclusive invitation to join us for an unforgettable experience.";
            // $msg = "Event happens ";
            // if($event->event_date!=null ){
            //     $msg .= " ".$event->event_date;
            // }
            // if($event->address!=null ){
            // $msg .= " at ".$event->address.".";
            // }
            // $msg .= "Event details link ".route('event-summary').'';

            return response()->json(['status' => "success", 'title' => $event->title , 'message' => $msg ], 200);
        } catch (Exception $e) {
             return response()->json(['status' => "error", 'event' => "" ,"error" => $e->getMessage()], 200);
        }

    }
    
}
