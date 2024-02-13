<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\{FeeLog,Status} ;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
class FeecheckController extends Controller
{
    
    public function checkIfPaymentAvailable($fee_log_enc){  
            $fee_log_id  = Crypt::decrypt( $fee_log_enc );
            $confirmation_message ="You cannot pay now!";
            try{
                $fee_log = FeeLog::findOrFail($fee_log_id);
                if( $fee_log->paid_date !=null){
                    return response()->json(['status' => "error", "redirect_route"=>"",'message' =>"Please refresh the page", 'message_title' => "Payment already recieved"], 200);
                }
                if( $fee_log->status_id == Status::STATUS_PAID){ 
                    return response()->json(['status' => "error", "redirect_route"=>"",'message' =>"Please refresh the page", 'message_title' => "Payment already recieved"], 200);
                }
                $paymentDueDate = Carbon::parse($fee_log->payment_due_date);
                if (Carbon::now()->diffInDays($paymentDueDate)  < 0 ){
                    return response()->json(['status' => "error","redirect_route"=>"", 'message' =>"Please refresh the page", 'message_title' => "Payment due date was passed.Please contact customer care."], 200);
                }
                $confirmation_message ="Select Yes and proceed to  continue with payment of " .priceFormatted($fee_log->amount) ."You will be redirected to external payment gateway." ;
                
                return response()->json(["confirmation_message" => $confirmation_message ,'status' => "success", "redirect_route" => route("payment.order-create", $fee_log_enc ) ,  'message' =>"Good to Go", 'message_title' => "Okay!"], 200);
        
            } catch (\Exception $e) { 
                return response()->json(['status' => "error","redirect_route"=>"", 'message' => $e->getMessage(), 'message_title' => "Failed to process"], 200);
            } 
    }
    
    public function paymentSummary($fee_log_enc){  
        $fee_log_id  = Crypt::decrypt( $fee_log_enc );
        try{
            $fee_log = FeeLog::unpaid()->findOrFail($fee_log_id);
            return view('telr.payment-summary',compact('fee_log'));
        }  catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            // Modify the error message
            $error = "No payment summary found. Please go back to the dashboard and retry the payment.";
            // Handle or log the exception
            // Log::error($exception);
        
            // You can return a response, throw a custom exception, or handle it based on your requirements
            return view('telr.payment-summary',compact('error'));
        }
        catch (\Exception $e) { 
            $error = $e->getMessage();
            return view('telr.payment-summary',compact('error'));
        } 
    }
    
 
}
