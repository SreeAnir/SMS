<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StaffPayment;
use Carbon\Carbon;
use App\Http\Requests\StaffPaymentRequest ;
use Illuminate\Support\Facades\DB;
use App\DataTables\StaffPaymentDataTable ;
use App\Models\Status;

class StaffPaymentController extends Controller
{
    public function __construct()
    {
         $this->authorizeResource(StaffPayment::class, 'staff_payment');
    }
    /**
     * Display a listing of the resource.
     */

    /**
     * Display a listing of the resource.
     */
    public function index(StaffPaymentDataTable $dataTable)
    {
        try {
        $paymet_statuses = Status::paymentStatuslist();    
        $users = User::select(['id','first_name','last_name','ID_Number'])->staff()->get();

        return $dataTable->render("admin.staff-payments.index",compact('paymet_statuses','users'));
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
        $staffs = User::select(['id','first_name','last_name','status_id'])->staff()->active()->get();
        return view('admin.staff-payments.create', compact('staffs') );
    }
 
      /**
     * Store a newly created resource in storage.
     */
    public function store(StaffPaymentRequest $request)
    {
        try {
            DB::beginTransaction();
            $payData = $request->getData();

            if ($payment = StaffPayment::create($payData)) {
                DB::commit();
                $response = ['status' => 'success', 'message' => 'Staff payment created successfully!'];
                return redirect()->route('staff-payments.show', $payment)->with($response);
            }

            $response = ['status' => 'error', 'message' => 'Failed to create Staff payment!'];
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
    public function show(StaffPayment $staff_payment)
    {
        $staffs = User::select(['id','first_name','last_name','status_id'])->where('id' , $staff_payment->user_id )->get();
        return view('admin.staff-payments.show', compact('staff_payment','staffs'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StaffPayment $staff_payment)
    {
        $staffs = User::select(['id','first_name','last_name','status_id'])->where('id' , $staff_payment->user_id )->get();
        return view('admin.staff-payments.edit', compact('staff_payment','staffs'));
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
    public function update(StaffPaymentRequest $request,StaffPayment $staff_payment)
    {
        try {
            DB::beginTransaction();
            $payData = $request->getData();

            if ($payment =$staff_payment->update($payData)) {
                DB::commit();
                $response = ['status' => 'success', 'message' => 'Staff payment updated successfully!'];
                return redirect()->route('staff-payments.show', $payment)->with($response);
            }

            $response = ['status' => 'error', 'message' => 'Failed to update Staff payment!'];
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
     /**
     * Get previous info on payment
     */
    public function staffPaymentInfo(Request $request)
    {
        try{
            $staff = User::find( $request->user_id );
            $message ="";
            $exists  = StaffPayment::where('user_id', $request->user_id  )->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->first(); 
            if($exists){
                $message ="Payment was already added on ".$exists->created_at." for this user."; 
            }
            return ['status' => 'success', 'message' =>  $message ,'staff' => $staff ];
        } catch (Exception $e) {  
            return ['status' => 'error', 'message' =>  $e->getMessage()];
        } 
    }
    
}
