<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BatchStudentDatatable;
use App\Events\AdminNewUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\StaffRequest;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Exception;
use App\Models\Batch;
use App\Models\Location;
use App\Models\Role;
use App\DataTables\BatchDataTable;
use App\DataTables\StaffDataTable;
use Validator;
use Illuminate\Support\Facades\DB;

class BatchController extends Controller
{
    public function __construct()
    {
         $this->authorizeResource(Batch::class, 'batch');
    }

    /**
     * Display a listing of the resource.
     */
public function index(BatchDataTable $dataTable)
{
    try {
    //    $locationList = Location::where('status_id', 1)->get();
        return $dataTable->render("admin.batches.index");
    } catch (Exception $e) { dd($e); 
        $response = ['status' => 'error', 'message' =>  $e->getMessage()];
        return redirect()->back()->with($response);
    } 
}


    public function data(BatchDataTable $dataTable)
    {  
        try {
        return $dataTable->eloquent(Batch::query())->toJson();
        }catch (Exception $e) {  
        // dd( $e );
        $response = ['status' => 'error', 'message' =>  $e->getMessage() ];
        return redirect()->back()->with($response);
    } 
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         try {
            $validator = Validator::make($request->all() , [
                'batch_name' => 'required|max:200',
                'batch_time' => 'required|max:200',
                'batch_location' => 'required',
                ]);

            if ($validator->fails())
            {
                $message = "Please enter valid batch details.";
                return response()->json(['status' => "fail", 'message' => $message, 'message_title' => "validation Fail!", 'debug' => $validator->errors() ], 200);
            }
           DB::beginTransaction();
           $batch = new Batch;
           $batch->batch_name = $request->batch_name;
           $batch->batch_time = $request->batch_time;
           $batch->location_id = $request->batch_location;
           if($batch->save())
           {
               DB::commit();

                    $response = ['status' => 'success', 'message' => 'Batch created successfully!'];
                    return response()->json($response, 200);

           }
            
        }catch (Exception $e) {  
            $response = ['status' => 'error', 'message' =>  $e->getMessage() ];
            return $response;
        } 
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     $batch = Batch::with('students')->where('id', $id )->get();

    //     return view('admin.batches.show', compact('batch') );
    // }

    public function show(Batch $batch)
    {
        $dt = new BatchStudentDatatable( $batch);
         $title =  'batch Details Details';
        // $dataTab = new CourseDataTable($tutor->id);
        // $dataTab->html()->ajax(route('admin.courses.index'))->parameters([
    //    ]);
        return $dt->render('admin.batches.show',array('batch' => $batch ,'title' => $title  ));
        // return view('pages.tutor.show', array('tutor' => $tutor ,'title' => $title , 'purchaseTable'=>$purchaseTable, 'dataTab' => $dataTab ));
    }

   

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Batch  $batch)
    {
        try
        {
            $data = array();
            // $locationList = Location::where('status', 1)->get();
            $data['batch'] = $batch ;
            // Batch::where('status_id','<>',0)->find($id);
            // $data['locationList'] = $locationList;
            $html = view('admin/batches/partials/add-batch', $data)->render();
                     $objData['content'] = $html;
            $time = "6am";
            if(!empty($data['batch']->batch_time))
            {
                $time = $data['batch']->batch_time;
            }
            return response()->json([
                'success'   => 'success',
                'message' =>  "Batch Data",
                'data'=>$html,
                "time"=>$time
              ]);
        }
        catch(Exception $ex)
        {
            return response()->json(['status' => "fail", 'token' => "", 'message' => "Error Occured!", 'message_title' => "Failed", 'debug' => $ex->getMessage() . " " . $ex->getLine() ], 200);
        }  
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Batch $batch)
    {
       try {
            $validator = Validator::make($request->all() , [
                'batch_name' => 'required|max:200',
                'batch_time' => 'required|max:200',
                'batch_location' => 'required',
                ]);

            if ($validator->fails())
            {
                $message = "Please enter valid batch details.";
                return response()->json(['status' => "fail", 'message' => $message, 'message_title' => "validation Fail!", 'debug' => $validator->errors() ], 200);
            }
           DB::beginTransaction();
        //    $batch = Batch::find($request->id);
           $batch->batch_name = $request->batch_name;
           $batch->batch_time = $request->batch_time;
           $batch->location_id = $request->batch_location;
           if($batch->save())
           {
               DB::commit();

                    $response = ['status' => 'success', 'message' => 'Batch updated successfully!'];
                    return response()->json($response, 200);

           }
            
        }catch (Exception $e) {  
            $response = ['status' => 'error', 'message' =>  $e->getMessage() ];
            return $response;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    
    
}
