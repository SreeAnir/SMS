<?php

namespace App\Http\Requests;

use App\Models\FeeLog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use App\Models\Transaction;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        $rules = [
            'first_name' => 'required|string',
            'sur_name' => 'required|string',
            'address_1' => 'required',
            // 'address_2' => 'required',
            // 'country' => 'required',
            'city' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'fee_log_enc' => 'required',
            'region' => 'required',
         ];
        return  $rules ;
    }
    public function getData()
    {
        $data = array();
        // $data['bill_fname']= $this->first_name;
        // $data['bill_sname']= $this->sur_name;
        // $data['bill_addr1']= $this->address_1;
        // $data['bill_addr2']= $this->address_2;
        // $data['bill_country']= ($this->country =="" ? 'AE' :$this->country) ;
        // $data['bill_city']= $this->city;
        // $data['phone']= $this->phone;
        // $data['bill_email']= $this->email;
        // $data['bill_region']= $this->region;
        // $data['bill_zip']= $this->bill_zip;
        $data['bill_phone']= $this->phone;
        $data['bill_country']= strtoupper($this->country =="" ? 'AE' :$this->country) ;
        $data['country']= strtoupper($this->country =="" ? 'AE' :$this->country) ;

        return Arr::except($this->validated(), ['fee_log_enc']) + $data;
        // Arr::except($this->validated(), ['fee_log_enc']);
    }
    // public function getOrderID()
    // {
    //     $lastRecordId = Transaction::latest()->value('order_id');

    //     return  $lastRecordId++ ;
    // }
    public function getPaymentInfo()
    {
        $fee_log_id  = Crypt::decrypt( $this->fee_log_enc  );
        $return = [];
        
            try{
                $fee_log = FeeLog::findOrFail($fee_log_id);
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
     
}
