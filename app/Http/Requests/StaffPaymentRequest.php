<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
class StaffPaymentRequest extends FormRequest
{
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
            'user_id' => 'required',
            'basic_salary' => 'required|decimal:0,4',
            'hra' => 'required|decimal:0,4',
            'other_allowance' => 'max:12',
            'note' => 'max:500'
        ];
        
        return match ($this->getMethod()) {
            'POST' => [
                    'user_id' => 'required',
                ] + $rules,
            'PUT', 'PATCH' => [
                    'user_id' => 'required',
                ] + $rules,
            default => []
        };
    }

    public function getData()
    {
        $data = [];
        $user = User::where('id' , $this->user_id )->first();
        $data['location_id'] =  $user->location_id ;
        $data['user_id'] =  $this->user_id ;
        $data['basic_salary'] =  $this->basic_salary ;
        $data['hra'] =  $this->hra ;
        $data['other_allowance'] =  $this->other_allowance ;
        $data['note'] =  $this->note;
        //Avoid password field here as it is computed separately
        return $data + $this->validated() ;
    }
}
