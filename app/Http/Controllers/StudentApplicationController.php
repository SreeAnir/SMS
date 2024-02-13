<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Student;
use App\Models\User;
use App\Mail\StudentCreatedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Exception;
use Illuminate\Support\Facades\Log;

class StudentApplicationController extends Controller
{
     /**
     * Show the form for creating a new resource.
     */
    public function newApplication()
    {
        return view('admin.students.new-application-form');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request)
    {
        // dd($request->all());
      
        try {
            DB::beginTransaction();
            $userData = $request->getUserData() ;
            $store =  $userData  ;
            unset(  $store['password_plain'] );
            // $store = $userData
            if ($user = User::create( $store )) {
                $studentData = $request->getStudentData() ;
                $studentData['user_id'] = $user->id ;
                $saved  = Student::create($studentData);
                // dd($saved);
                //email the student

                Mail::to($user->email)->queue(new StudentCreatedMail($user  ));

                // $user?->notify(new UserCreated( $user,"Test"));

                DB::commit();
                $response = ['status' => 'success', 'message' => 'Your Application sent successfully!'];

                return redirect()->route('application.success', $user)->with($response);
            }
            $response = ['status' => 'error', 'message' => 'Failed to create user!'];
            return redirect()->back()->with($response);
        }catch (Exception $e) { 
            DB::rollback();
            Log::error('New User Reg error '. $e->getMessage().'on ' .$e->getLine());
            $response = ['status' => 'error', 'message' =>  "Failed to send application" ];
            return redirect()->back()->with($response);
        } 
    }

      /**
     * Show the form for creating a new resource.
     */
    public function success()
    {

        if(session()->has('status')){
            return view('admin.students.partials.success');
        }
        return redirect('/');
    
    }

    
}
