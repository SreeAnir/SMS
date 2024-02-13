<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class StaffRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'ID_Number' => 'required|string|max:5',
            'location_id' => 'required',
            'phone_number' => 'required',
            'phone_code' => 'required',
            'gender' => 'required',
            'ID_Number' => 'required',
            'present_address' => 'required',
            'permanent_address' => 'required',
            'alt_phone_number' => 'nullable|string|max:10',
            'alt_phone_code' => 'nullable|string|max:4',
            'home_phone_number' => 'nullable|string|max:10',
            'home_phone_code' => 'nullable|string|max:4',
            'emergency_phone_number' => 'required',
            'emergency_phone_code' => 'required',
            'emergency_contact_person' => 'required',
            'emergency_contact_person_relation' => 'required',
            'visa_uid' => 'nullable|string|max:15',
            'visa_file_no' =>  'nullable|string|max:15',
            'visa_issue_date' => 'nullable|string|max:15',
            'visa_expiry_date' => 'nullable|string|max:15',
            'passport_number' =>  'nullable|regex:/^[A-Z0-9]{6,}$/',
            'passport_issue_date' =>  'nullable|string|max:10',
            'passport_expiry' =>  'nullable|string|max:10',
            'emirates_id' => 'required|string|max:15',
            'emirates_id_expiry' => 'required|string|max:10',
            'iban_no' =>  'nullable|string|max:16',
            'bank_name' =>  'nullable|string|max:16',
            'bank_branch' => 'nullable|string|max:16',
            'insurance_provider' => 'nullable|string|max:16',
            'policy_no' => 'nullable|string|max:16',
            'policy_plan' => 'nullable|string|max:16',
            'policy_expiry_date' =>'nullable|string|max:10',
            'location_id' => 'required'
        ];
        return match ($this->getMethod()) {
            'POST' => [
                    'email' => 'required|email|unique:users,email',
                ] + $rules,
            'PUT', 'PATCH' => [
                    'email' => 'required|email|unique:users,email,'.$this->route('staff')->getKey() ,
                ] + $rules,
            default => []
        };
    }

    public function getData()
    {
        $data = [];
        $data['phone_code'] =  $this->phone_code;
        $data['phone_number'] =  $this->phone_number;
        $data['user_type'] =  $this->user_type;
        $data['gender'] =  $this->gender;
        $data['location_id'] =  $this->location_id;
        $data['location_id'] =  $this->location_id;
        $data['rfid'] =  $this->rfid;
        $data['ID_Number'] =  $this->ID_Number;
             

        return $data + $this->validated() ;
    }
    public function getStaffData()
    {
        $data = [];
        $data['present_address']            =  $this->present_address;
        $data['permanent_address']          =  $this->permanent_address;
        $data['alt_phone_number']           =  $this->alt_phone_number;
        $data['alt_phone_code']             =  $this->alt_phone_code;
        $data['home_phone_number']          =  $this->home_phone_number;
        $data['home_phone_code']            =  $this->home_phone_code;
        $data['emergency_phone_number']     =  $this->emergency_phone_number;
        $data['emergency_phone_code']       =  $this->emergency_phone_code;
        $data['emergency_contact_person']   =  $this->emergency_contact_person;
        $data['emergency_contact_person_relation'] =  $this->emergency_contact_person_relation;
        $data['visa_uid']                   =  $this->visa_uid;
        $data['visa_file_no']               =  $this->visa_file_no;
        $data['visa_issue_date']            =  $this->visa_issue_date;
        $data['visa_expiry_date']           =  $this->visa_expiry_date;
        $data['passport_number']            =  $this->passport_number;
        $data['passport_issue_date']        =  $this->passport_issue_date;
        $data['passport_expiry']            =  $this->passport_expiry;
        $data['emirates_id']                =  $this->emirates_id;
        $data['emirates_id_expiry']         =  $this->emirates_id_expiry;
        $data['iban_no']                    =  $this->iban_no;
        $data['bank_name']                  =  $this->bank_name;
        $data['bank_branch']                =  $this->bank_branch;
        $data['insurance_provider']         =  $this->insurance_provider;
        $data['policy_no']                  =  $this->policy_no;
        $data['policy_plan']                =  $this->policy_plan;
        $data['policy_expiry_date']         =  $this->policy_expiry_date;
        return $data + $this->validated() ;
    }
}
