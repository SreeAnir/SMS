<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TransactionRequest;
use App\Models\{AccountingCategory, Transaction,Status,FeeLog,Fee,Accounting};
use App\Services\NotificationService ;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class PaymentController extends Controller
{
    
    ///paymentOrderCreateFromForm wont be required
    public function paymentOrderCreateFromForm(TransactionRequest $request){  
        try{  
        $telrManager = new \TelrGateway\TelrManager();

        $order_id =$request->getPaymentInfo()['order_id'] ;
        $total =  $request->getPaymentInfo()['amount'];
        $billingParams  = $request->getData();
        $url_link = $telrManager->pay($order_id, $total,  $request->getPaymentInfo()['description'] , $billingParams)->redirect();
        $url = $url_link->getTargetUrl();
        Log::error('billingParams: '  . json_encode( $billingParams ));
            return redirect($url);
        }catch (\Exception $e) { 
            return back()->withErrors("Failed to proceed");
        }
    }

    public function getOrderInfo($fee_log)
    {
        $return = [];
        
            try{
                if( $fee_log == ""){
                    $return['description'] ="";
                    $return['amount'] ="";
                    $return['order_id'] ="";
                    
                }else{
                    $return['amount'] =$fee_log->amount ;
                    $return['order_id'] =$fee_log->id ;
                    $return['description'] =  'Payment for student fee #' . auth()->user()->ID_Number . '(' . $fee_log->id . '-' . $fee_log->fee_id . '-' . $fee_log->current_installment.")";
                }
         
            } catch (\Exception $e) { 
                 
            } 
            return  $return;

    }
    public function getData($fee_log)
    {
        $data = array();
        $user =auth()->user();

        // 'first_name' => 'required|string',
        // 'sur_name' => 'required|string',
        // 'address_1' => 'required',
        // 'city' => 'required',
        // 'phone' => 'required',
        // 'email' => 'required',
        // 'region' => 'required',
        
        $data['bill_phone']= $user->phone_code. $user->phone_number;
        $data['bill_country']= strtoupper($user->country_id =="" ? 'AE'  :$user->country->name) ;
        $data['country']= strtoupper($user->country_id =="" ? 'AE'  :$user->country->name) ;
        $data['first_name']=  $user->first_name  ;
        $data['sur_name']=  $user->last_name  ;
        $data['city']= strtoupper($user->location_id =="" ? $user->location->name   : "Not Available") ; 
        $data['address_1']= strtoupper($user->location_id =="" ? $user->location->name   : "Not Available") ; 

        $data['phone']= $user->phone_code. $user->phone_number;
        $data['email']= $user->email ;
        $data['region']= strtoupper($user->location_id =="" ? $user->location->name   : "Not Available") ; 
        return  $data;
        // Arr::except($this->validated(), ['fee_log_enc']);
    }
    public function paymentOrderCreateforLog($fee_log_enc){  
        $fee_log_id  = Crypt::decrypt( $fee_log_enc );
        $fee_log = FeeLog::find($fee_log_id);
        try{  
        $telrManager = new \TelrGateway\TelrManager();
        $order_info = $this->getOrderInfo($fee_log);
        $order_id = $order_info['order_id'] ;
        $total =  $order_info['amount'];
        $billingParams  = $this->getData( $fee_log);
        $url_link = $telrManager->pay($order_id, $total,  $order_info['description'] , $billingParams)->redirect();
        $url = $url_link->getTargetUrl();
        Log::error('billingParams: '  . json_encode( $billingParams ));
            return response()->json([  'status' => "success", "redirect_route" => $url ,  'message' =>"Please watit", 'message_title' => "Redirecting to Payment page"], 200);

        }catch (\Exception $e) { 
            return response()->json([  'status' => "error", "redirect_route" => "" ,  'message' =>$e->getMessage(), 'message_title' => "Failed to create order"], 500);
        }
    }

    

    public function payment(Request $request){  
        $telrManager = new \TelrGateway\TelrManager();

        $order_id = rand(1,99999);
        $total = 1;
        $billingParams = [
            'first_name' => 'Trictatest',
            'sur_name' => 'Xyz',
            'address_1' => 'Test Address',
            'city' => 'Dubai',
            'zip' => 123456,
            'country' => 'UAE',
            'phone' => 12333333333,
            'email' => 'trictatest@mailinator.com',
        ];
        
        $url_link = $telrManager->pay($order_id, $total, 'trictatest Test Payment Details', $billingParams)->redirect();
        $url = $url_link->getTargetUrl();
        return redirect($url);
    }

    public function paymentSuccess(Request $request){     
        // Store Transaction Details 
        $telrManager = new \TelrGateway\TelrManager();
        $transaction = $telrManager->handleTransactionResponse($request);

        //Card Details
        $card_last_4 = $transaction->response['order']['card']['last4'];
        $card_holder_name = $transaction->response['order']['customer']['name']['forenames']." ".$transaction->response['order']['customer']['name']['surname'];

        //Queries
        $paymentDetails = Transaction::where('cart_id',$request->cart_id)->firstOrFail();
        
        // Display Result Of Response
        // dump('paymentSuccess :: ',$transaction);
        // dump('transaction Response :: ',$transaction->response);
        // dd('payment Details :: ',$paymentDetails); 

        // Handle Order & Email Related Other Things
        $this->updateOrderInstallment($paymentDetails->order_id, "success");

        return redirect(route('payment-status',['status' => 'success','order_id' => $paymentDetails->order_id ]));
    }
    public function paymentCancel(Request $request){
        $telrManager = new \TelrGateway\TelrManager();
        $transaction = $telrManager->handleTransactionResponse($request);

        // Display Result Of Response

        // dd('paymentCancel :: ',$transaction);
        return redirect(route('payment-status',['status' => 'canceled','order_id' =>null ]));

        }
    public function paymentDeclined(Request $request)
        {
           $telrManager = new \TelrGateway\TelrManager();
           $transaction = $telrManager->handleTransactionResponse($request);

           $paymentDetails = Transaction::where('cart_id',$request->cart_id)->firstOrFail();
           $this->updateOrderInstallment($paymentDetails->order_id, "declined");
           // Display Result Of Response
        //    dd('paymentDeclined :: ',$transaction);
           return redirect(route('payment-status',['status' => 'declined','order_id' =>null ]));

    }       
    public function paymentStatus($status,$order_id=null)
    {
        $transaction = null ;
        if( $order_id !=null){
            $transaction = Transaction::where('order_id',$order_id)->firstOrFail();
        }
        return view('telr.payment-status',compact('transaction','status'));
    }   
    public function updateOrderInstallment($feelog_id , $status ){
        if( $status == "success"){
            $feelog = FeeLog::find(  $feelog_id );
            $feelog->status_id =  Status::STATUS_PAID ;
            $feelog->paid_date = now();
            $feelog->save();
            if( $feelog->current_installment == $feelog->fee->installment_nos ){
                Fee::where('id',  $feelog->fee_id )->update(['status_id' =>  Status::STATUS_PAID ]);
            }
            $category= AccountingCategory::where('category_label', 'LIKE', "%Fee and Admission%")->first();
            if( $category!=null){
                Accounting::create([
                    "category_id" => $category->id ,
                    "acc_type" => 1 ,
                    "amount" => $feelog->amount ,
                    "location_id" => auth()->user()->location_id ,
                    "date" => now() ,
                    "remarks" => 'telr'
                ]);
            }
            $service = new NotificationService(); 
            $service->paymentDone( auth()->user() ,  $feelog  );
            // Mail::to(auth()->user()->email)->queue(new FeePaymentMail($feelog  , $status  ));

        }else{
            $feelog = FeeLog::find(  $feelog_id );
            $feelog->status_id =  Status::STATUS_UNPAID ;
            $feelog->save();
            
            $service = new NotificationService(); 
            $service->paymentDone( auth()->user() ,  $feelog  );
            // Mail::to(auth()->user()->email)->queue(new FeePaymentMail($feelog  , $status  ));

        }
    }   
        
}
