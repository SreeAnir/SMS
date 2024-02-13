<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\KachaAssignEmail;
use App\Models\Student;
use App\Models\User;
use App\Models\Status ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;
use Exception;

class StudentKachaController extends Controller
{
    
     /**
     * Display the specified resource.
     */
    public function saveStudentKatcha(Request $request)
    {

        $validator = Validator::make($request->all() , 
            [
            'student_id' => 'required|max:2',
            'kacha_id' => 'required|max:1',
        ]);
        if ($validator->fails())
        {
            $message = "Please enter valid batch details.";
            return response()->json(['status' => "fail", 'message' => $message, 'message_title' => "validation Fail!", 'debug' => $validator->errors() ], 200);
        }
        try {
            $student =  Student::find( $request->student_id );
            $student->kacha_id =  $request->kacha_id ;
            $student->save();
            $user = $student->user ;
            $student->kachas()->attach($request->kacha_id, ['class_count' => 0,'creator_id' => auth()->user()->id ,'created_at' => now() ]);

            $html = view('common.kacha-badge', ['instance' => $student] )->render();
            Mail::to($user->email)->queue(new KachaAssignEmail($user));

            return response()->json(['status' => "success", 'message' =>"Updated the Kacha Details", "html" => $html ], 200);
        }catch (Exception $e) {  
            return response()->json(['status' => "error", 'message' =>  $e->getMessage() , "html" => '' ], 200);
        } 
    }
}
