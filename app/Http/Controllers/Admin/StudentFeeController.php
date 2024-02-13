<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Fee;
use App\Models\FeeLog;
use App\Http\Requests\FeeRequest ;
use Illuminate\Support\Facades\DB;
use Exception ;
use App\Models\Status;
use App\Models\Batch;
use App\DataTables\StudentFeeDataTable ;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use App\Mail\PaymentRecievedMail;
use Illuminate\Support\Facades\Mail;

class StudentFeeController extends Controller
{
     
     /**
     * Display a listing of the resource.
     */
    public $installment_failed_message ;
    public function index(StudentFeeDataTable $dataTable)
    {
        try {
            $batches = Batch::get();  
            $paymet_statuses = Status::paymentStatuslist();    
            $users = User::select(['id','first_name','last_name','ID_Number'])->studentType()->get();

            return $dataTable->render("admin.fees.index",compact('paymet_statuses','batches','users'));
        }catch (Exception $e) {  
            $response = ['status' => 'error', 'message' =>  $e->getMessage() ];
            return redirect()->back()->with($response);
        } 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function manage(Request $request)
    {

        $student_id = $request->query('student_id');
        if($student_id !=null){
           if(!User::studentType()->where('id', $student_id)->exists()){
            session()->flash('status', 'error');
            session()->flash('message', 'No User found for the selection');
           }
        }
        $users = User::select(['id','first_name','last_name','ID_Number'])->studentType()->get();
      
        return view('admin.fees.create' , compact('users' ));
    }
    
      /**
     * Display the specified resource.
     */
    public function studentInfo(Request $request)
    {
        try {
            $user_id =  $request->user_id ;
            $user = User::with(['fee' => function($query){
                $query->active();
            }])->find($user_id);
            $past_fee = Fee::where('user_id', $user_id)->paid()->orderBy('created_at','desc')->get(); 
            $batches = "";
            $batch_location = "";
            $branch_id = "";

            if ( $user ) {
              
            if(  $user->student->batches->count() > 0  ){
               $batches =  implode(', ',  $user->student->batches->pluck('batch_name')->toArray() );
               $batch_location =  ( $user->student->batches[0]->location !=null ? $user->student->batches[0]->location->name : "");
               $branch_id = ( $user->student->batches[0]->id !=null ? $user->student->batches[0]->location->id : "");
            }
                $info = array(
                    'name' => $user->full_name,
                    'batches' =>  $batches ,
                    'branch' => $batch_location ,
                    'location_id' => $branch_id ,
                    'amount' =>  0,
                    'discount' =>  0,
                    'installment_nos' =>  1,
                    'fee_type' =>  1,
                    'fee_id' =>  '',
                );
                if($user->fee !=""){ 
                    $info['amount'] =  $user->fee->amount;
                    $info['discount'] =  $user->fee->discount;
                    $info['installment_nos'] =  $user->fee->installment_nos;
                    $info['fee_type'] =  $user->fee->fee_type;
                    $info['fee_id'] =  $user->fee->id;
                }
                 $add_pay_btn = true ;
                    $installment_content = view('admin.fees.partials.installments',compact('user','past_fee','add_pay_btn'))->render();
                    return response()->json(['status' => "success", "info" => $info  , "installment_content" => $installment_content ], 200);
                } else {
                    return response()->json([ 'status' => "error", "message" => "Server Error occured" ], 404);
                }
            } catch (Exception $e) {
                // return response()->json(['error' => 'User not found'], 404);
                return response()->json(['status' => "error", "message" => "Server Error occured","err" => $e->getMessage()], 404);

            }
         

    }

       /**
     * Display the specified resource.
     */
    public function nextPayment(Request $request)
    {
        try {
            $user_id =  $request->user_id ;
            $fee = Fee::with(['newpayment' => function ($query) {
                $query->orderBy('payment_due_date', 'asc');
            }])->active()->where('user_id', $user_id)->first();
            $payment_content = view('admin.fees.partials.payment_modal',compact('fee'))->render();
            return response()->json(['status' => "success",   "payment_content" => $payment_content ], 200);
                 
            } catch (Exception $e) {
                // return response()->json(['error' => 'User not found'], 404);
                return response()->json(['status' => "error", "message" => "Server Error occured"], 404);

            }
         

    }

    
       /**
     * Display the specified resource.
     * Not using
     */
    public function previewInstallmentInfo(Request $request)
    {
        try {
            $details  = $request->all();
            $this->getInstallmentHtml($details);
            // $batches = "";
            // $batch_location = "";
            // if ( $user ) {
              
            // if(  $user->student->batches->count() > 0  ){
            //    $batches =  implode(', ',  $user->student->batches->pluck('batch_name')->toArray() );
            //    $batch_location =  ( $user->student->batches[0]->location !=null ? $user->student->batches[0]->location->name : "");
            // }
            // $info = array(
            //     'name' => $user->full_name,
            //     'batches' =>  $batches ,
            //     'branch' => $batch_location ,
            //     'amount' =>  0,
            //     'discount' =>  0,
            //     'installment_nos' =>  0,
            //     'fee_type' =>  1,
            // );
            // if($user->fee !=""){ 
            //     $info['amount'] =  $user->fee->amount;
            //     $info['discount'] =  $user->fee->discount;
            //     $info['installment_nos'] =  $user->fee->installment_nos;
            //     $info['fee_type'] =  $user->fee->fee_type;
            // }
            //         $installment_content = view('admin.fees.partials.installments',compact('user'))->render();
            //         return response()->json(['status' => "success", "info" => $info  , "installment_content" => $installment_content ], 200);

            //     } else {
            //         return response()->json(['error' => 'User not found'], 404);
            //     }
            } catch (Exception $e) {

            }
    }
    
     /**
     * Store a newly created resource in storage.
     */
    public function getInstallmentHtml($fee_details)
    {
         $amount = $fee_details['amount'];
         $fee_type = $fee_details['fee_type'];
         $installment_nos = $fee_details['installment_nos'];
         $discount = $fee_details['discount'];
         $installment_amount = ($amount - $discount ) / $installment_nos;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FeeRequest $request)
    {
        try {
            $feeData = $request->getData() ;
            $feeData['creator_id'] = auth()->user()->id ;
            DB::beginTransaction();
            if ($fee = Fee::create( $feeData )) {
                $installment_create = $this->makeInstallment($fee);
                $message ="Successfully updated fees for the student.";
                $installment_error = ""; 
                if( !$installment_create === true ){  
                    $message .="Failed to save installment details.";
                    $installment_error = $installment_create ;
                }
                    
                DB::commit();
                return response()->json(['status' => "success", "message" => "Successfully added fees for the student"  ], 200);
            }
            return response()->json(['status' => "error", "message" => "Failed to add fees for the student" ], 200);
        }catch (Exception $e) { 
            DB::rollback();
            return response()->json(['status' => "error", "message" => $e->getMessage()], 500);

        } 
    }
    
     /**
     * Store a newly created resource in storage.
     */
    public function makeInstallment($fee)
    {
        try {
            $installment_failed_message = '';
            $amount = $fee->amount ;
            $installment_nos = $fee->installment_nos ;
            FeeLog::where('fee_id', $fee->id )->where('status_id','<>',Status::STATUS_PAID )->forceDelete();
            $existing_logs_amount =  FeeLog::where('fee_id', $fee->id )->where('status_id', Status::STATUS_PAID )->sum('amount');  
            $paid_installments =  FeeLog::where('fee_id', $fee->id )->where('status_id',Status::STATUS_PAID )->orderBy('current_installment','desc')->get();  
            $already_paid = $paid_installments->count();
            if( $installment_nos <= $already_paid ){
                $this->installment_failed_message =   "Number Installment(s) is ".$installment_nos.' , but user has already paid '.$already_paid. " installment(s)";
                return false; 
            }
            $current_installment =$already_paid + 1 ;
            $amount =  $amount -  $existing_logs_amount ;
            $installment_nos = $installment_nos - $already_paid ;
            
            $discount = $fee->discount ;
            $fee_type = $fee->fee_type ;
            $ins_amt = ($amount - $discount  ) / $installment_nos;
            $instalment_row =[];
            $payment_due_date =  ( $fee->user->joining_date !=null ? $fee->user->joining_date : now()) ;   
            $days =  $fee_type * 30 ;
            if($already_paid > 0 ){
                $payment_due_date =  $paid_installments[0]->payment_due_date ; 

                $carbonDate = Carbon::parse($payment_due_date);

                // Add 7 days to the current date
                $futureDate = $carbonDate->addDays($days);

                // Format the future date as a string
                $payment_due_date = $futureDate->format('Y-m-d H:i:s');
            }
            for( $i = 1  ; $i <= $installment_nos ; $i ++ , $current_installment++) {

                 $instalment_row[] = 
                    ['fee_id'=> $fee->id ,'current_installment'=> $current_installment  , 'amount' => $ins_amt , 'payment_due_date' => $payment_due_date ,'created_at' => now() ]
                ;
                $carbonDate = Carbon::parse($payment_due_date);

                $futureDate = $carbonDate->addDays($days);

                $payment_due_date = $futureDate->format('Y-m-d H:i:s');
            }
            if( count( $instalment_row )> 0){  
                FeeLog::insert($instalment_row); // Eloquent
            }
            return true; 
        }catch (Exception $e) {  
            // return false;
            $this->installment_failed_message =  $e->getMessage() ;
                return false; 
        } 
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       

        if(!Fee::where('id', $id)->exists()){
            $response = ['status' => 'error', 'message' =>   "No User found for the selection"];
            return redirect()->back()->with($response);
           }
           $student = Fee::where('id', $id)->first()->user_id;
           $newUrl = route('admin.student-fees.manage', ['student_id' => $student ,'add_pay_btn' =>true]);
           return redirect($newUrl);

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
    public function update(FeeRequest $request, String $fee_id)
    {

        try {
            $fee = Fee::where('id', $fee_id )->first();
            if( $fee ==null ){
                return response()->json(['status' => "error", "message" => "Reload the page" ], 200);

            }
            $feeData = $request->getData() ;
            DB::beginTransaction();
            if ($update = $fee->update($feeData)) {

                DB::commit();
                $installment_create = $this->makeInstallment($fee);
                $message ="Successfully updated fees for the student.";
                $installment_error = ""; 
                if(  $this->installment_failed_message != '' ){  
                    $message ="Failed to save installment details.";
                    $message .= $this->installment_failed_message ;
                } 
               
                return response()->json(['status' => "success", "message" =>  $message ,"installment_error" => $this->installment_failed_message ], 200);
            }
            return response()->json(['status' => "error", "message" => "Failed to add fees for the student" ], 200);
        }catch (Exception $e) { 
            DB::rollback();
            return response()->json(['status' => "error", "message" => $e->getMessage()], 500);

        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    
     /**
     * Update the fee log with payment info
     * paid_date,transaction_info,remarks,fee_log_id
     */
    public function saveFeePayment(Request $request)
    {
        try{ 
        $request->validate([
            'paid_date' => 'required',
            'transaction_info' => 'max:8',
            'remarks'=> 'max:400',
            'fee_log_id'=> 'required:min:10',
        ]);
        $fee_log_id = Crypt::decrypt($request->fee_log_id );
        $fee_log = FeeLog::with('fee')->where('id',$fee_log_id)->first();
        if( $fee_log->fee == null ){
            return response()->json(['status' => "error", "message" =>  "No courses assigned for the student.No Fees details found " ], 200);
        }
        if( $fee_log == null ){
            return response()->json(['status' => "error", "message" =>  "Invalid Payment selection.Please check the selected student & fees details " ], 200);
        }
        if( $fee_log->status_id == STATUS::STATUS_PAID ){
                return response()->json(['status' => "error", "message" =>  "This payment was already done on ".  $fee_log->paid_date], 200);
        }
        DB::beginTransaction();
        $fee_log->paid_date = $request->paid_date;
        $fee_log->status_id = STATUS::STATUS_PAID ;

        $fee_log->transaction_info = $request->transaction_info;
        $fee_log->remarks = $request->remarks;
        $fee_log->exists =true ;
        $fee_log->save();
        if( $fee_log->current_installment ==  $fee_log->fee->installment_nos ){
            $fee_log->fee->update([
                'status_id' => STATUS::STATUS_PAID,  
             ]);
        }

        DB::commit();
        // $user = $fee_log->fee->user ;
        // Mail::to($user->email)->queue(new PaymentRecievedMail($fee_log ));

        // $fee_log = FeeLog::with('fee')->where('id', 12 )->first(); ///test record
        $user = $fee_log->fee->user ;
        $batch = $fee_log->fee->user->student->batch; 
        if( $batch->count() > 0){
          $subject =   'Payment Receipt and Acknowledgment - '.env('APP_NAME').'  Batch '. @$batch[0]->batch_name .', '.@$batch[0]->location->name ;
        }else{
            $subject =   'Payment Receipt and Acknowledgment - '.env('APP_NAME') ;
        }
        Mail::to($user->email)->queue(new PaymentRecievedMail($fee_log , $subject));

        return response()->json(['status' => "success", "message" =>  "Payment for the student fee has been added.Email notification will be sent to the student" ], 200);
        }catch (Exception $e) { 
            DB::rollback();
            return response()->json(['status' => "error", "message" => $e->getMessage()], 500);

        } 
    }
}
