<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\StudentDataTable;
use App\Http\Controllers\Controller;
use App\Models\{
    Student,User,Kacha,Status,KachaStudent,Fee
};
use Exception;
use App\Http\Requests\StudentRequest;
use Illuminate\Support\Facades\DB;
// use App\Notifications\UserCreated;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreatedMail;
class StudentController extends Controller
{
    public function __construct()
    {
         $this->authorizeResource(Student::class, 'user');
    }
    /**
     * Display a listing of the resource.
     */


    public function index(StudentDataTable $dataTable  )
    {
        try {
            $new_application_count =  User::StudentType()->where('status_id' , Status::STATUS_PENDING)->count();
            return $dataTable->render("admin.students.index",compact('new_application_count'));
        }catch (Exception $e) {  
            $response = ['status' => 'error', 'message' =>  $e->getMessage() ];
            return redirect()->back()->with($response);
        } 
    }
    
    public function data(StudentDataTable $dataTable)
    {  
        try {
        return $dataTable->eloquent(User::query())->toJson();
        }catch (Exception $e) {  
        // dd( $e );
       return $response = ['status' => 'error', 'message' =>  $e->getMessage() ];
    } 
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $batches = array();
        return view('admin.students.create-form',compact('batches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request)
    {
        try {
            DB::beginTransaction();
            $userData = $request->getUserData() ;
            $store =  $userData  ;
            unset(  $store['password_plain'] );
            if ($user = User::create( $store )) {
                $studentData = $request->getStudentData() ;
                $studentData['user_id'] = $user->id ;
                $saved  = Student::create($studentData);
                //email the student
                KachaStudent::create([ 
                    'student_id' =>   $saved->id ,
                    'kacha_id' => 1,
                    'class_count' => 0 ,
                    'creator_id' =>   auth()->user()->id 

                ]);
                Mail::to($user->email)->queue(new UserCreatedMail($user , "Test@123" ));

                // $user?->notify(new UserCreated( $user,"Test"));

                DB::commit();
                $response = ['status' => 'success', 'message' => 'Student Profile created successfully!'];

                return redirect()->route('students.show', $user)->with($response);
            }

            $response = ['status' => 'error', 'message' => 'Failed to create user!'];
            return redirect()->back()->with($response);
        }catch (Exception $e) { 
            DB::rollback();
            $response = ['status' => 'error', 'message' =>  $e->getMessage() ];
            return redirect()->back()->with($response);
        } 
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // $permissions = $user->getPermissions();
        $batches = array();
        $current_kacha_class = 0;
        // $class_plus = $user->student->class_count ;
        $kachas = Kacha::get();
        $profile_alerts =[];
        if($user->student->kacha != "" ){
            $latest = $user->student->kachaStudents()->latest()->first();
            if($latest != null ){
                $current_kacha_class = $latest->class_count;
            }
            // $class_plus = $class_plus - Kacha::where('level','<=',$user->student->kacha_id )->sum('class_count');
            $curr =  (int) $user->student->kacha_id   ;
            if( $curr >= 2  ){
                  $curr ++;
                $kachas = Kacha::where('level',   $curr )->get();
            }
          
        }
        if( $user->rfid ==""){
            $profile_alerts[] ="RFID has not added.";
        }
        if( $user->joining_date ==""){
            $profile_alerts[] ="Update joing date.Go to edit page";
        }
        if( $user->status_id != Status::STATUS_ACTIVE){
            $profile_alerts[] ="Student is not acitve.Approve the student.";
        }
        if( $user->location_id == ""){
            $profile_alerts[] ="Branch Location/Batch is missing.";
        }
        $past_fee = Fee::where('user_id', $user->id )->paid()->orderBy('created_at','desc')->get(); 
        return view('admin.students.show', compact('user','past_fee','batches','kachas','current_kacha_class','profile_alerts' ) );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $student = Student::where('user_id',$user->id)->first();
        return view('admin.students.create-form',compact('user','student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentRequest $request,User $user)
    {
         try{
            DB::beginTransaction(); 
                $user->update($request->getUserData());
                $student_data = $request->getStudentData();
                $user->student()->update($student_data);
                $user->save();
                // $student_update = Student::where('user_id', $user->id)->first();
                // $student_update->update( $student_data );
                // $st = $user->save();
                DB::commit();
            $response = ['status' => 'success', 'message' => 'User Details updated successfully!'];
            return redirect()->route('students.show', ['user' => $user])->with($response);

        }catch (Exception $e) {  
            DB::rollback();
            $response = ['status' => 'error', 'message' =>  $e->getMessage() ];
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
}
