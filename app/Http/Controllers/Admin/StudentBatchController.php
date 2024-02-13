<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\BatchAssignEmail;
use App\Mail\BatchAssignNotifyAdmin;
use App\Models\Student;
use App\Models\User;
use App\Models\Status ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Exception;

class StudentBatchController extends Controller
{
    
    
    public function saveStudentRFID(Request $request,User $user)
    {
        try {
        if( $request->rfid !="" ){
            $query = "select * from  Employees where EmployeeCode=". $request->rfid;
            $emp = DB::connection('epushserver')->select($query);   
            if( count($emp) == 0){
                return response()->json(['status' => "error", 'message' =>"Failed to Update.No Emp.Code Found"], 200);
            }
            if( User::where( 'rfid' , $request->rfid )->where('id','<>',$user->id )->exists()){
                return response()->json(['status' => "error", 'message' =>"Failed to Update.Already assigned to another student user"], 200);
            }
            $rfid =  ( $emp[0]->EmployeeRFIDNumber =="" ? "-----": $emp[0]->EmployeeRFIDNumber ); 
            $name = $emp[0]->EmployeeName;
            DB::beginTransaction();
            $user->rfid = $request->rfid ;
            $user->save();
            DB::commit();
            $info ="Note: RFID for the Emp.Code ".$request->rfid." in essl is ".$rfid ." and Name is ".$name ;
            return response()->json(['status' => "success", 'message' =>"Updated student rfid details", "info" => $info ], 200);

        }
        return response()->json(['status' => "error", 'message' =>"Failed to Update", "udpate" => false ], 200);
        DB::rollback();
        }catch (Exception $e) { 
            return response()->json(['status' => "error", 'message' =>"Failed to Update", "error" => $e->getMessage() ], 200);

        }

    }
     /**
     *  
     */
    public function saveStudentBatch(Request $request)
    {
        $student_id = $request->student_id;
        $batch_id = $request->batch_id;
        $loc_id = $request->location_id;
        $student = Student::find($student_id);
        
        User::where('id', $student->user_id)->update([ 'location_id' => $loc_id , 'status_id' => Status::STATUS_ACTIVE ]);
        $newBatchIds = [ $batch_id ]; // Replace with the new batch IDs.
        $user = $student->user;

        if($user->ID_number ==""){
            $user->ID_number = 'kc' . str_pad($user->id, 4, '0', STR_PAD_LEFT);
            $user->user_name =  "kal-". strtoupper( Str::random(2). $user->status_id   ) ;
            $user->save();
        }
        // $student->batches()->detach($oldBatchId);
        // $update = $student->batches()->attach($batch_id); only 
        $update = $student->batches()->sync($newBatchIds);

        Mail::to($user->email)->queue(new BatchAssignEmail($user));
        $super = User::SU()->first();
        Mail::to($super->email)->queue(new BatchAssignNotifyAdmin($user));

        return response()->json(['status' => "success", 'message' =>"Updated student batch", "udpate" => $update ], 200);
    }
}
