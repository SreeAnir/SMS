<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeeRequest extends FormRequest
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
  
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    { 
        $rules = [
            'user_id' => 'required|string',
            'fee_type' => 'required|string',
            'amount' => 'required|string|max:20',
            'installment_nos' => 'required',
            'location_id' => 'required',
        ];
        return match ($this->getMethod()) {
            'POST' => [
                 ] + $rules,
            'PUT', 'PATCH' => [
                    
                ] + $rules,
            default => []
        };
    }

    public function getData()
    {
        $data = [];
        // $data['user_id'] =  $this->user_id;
        // $data['fee_type'] =  $this->fee_type;
        // $data['amount'] =  $this->amount;
        $data['discount'] =  $this->discount;

        // $data['installment_nos'] =  $this->installment_nos;
        return $data + $this->validated() ;

    }
    
}
