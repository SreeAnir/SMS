<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

use App\Models\User ;
class StudentRequest extends FormRequest
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
            'last_name' => 'required|string',
            'gender' => 'required',
            'email' => 'required',
            'weight' =>'required|integer',
            'country_id' =>'required|integer',
            'phone_number' =>'required|max:16',
            'residency_phone' =>'required|max:16',
            'emergency_contact' =>'required|max:16',
            'emergency_contact_2' =>'required|max:16',
            'blood_group' => 'required',
            'po_box' =>'required',
            'dob' =>'required',
            // 'parent_name' =>'required',
            // 'parent_occupation' =>'required',
            // 'parent_phone' =>'required',
            'relative_enrolled' =>'required',
            'relative_name' => 'required_if:relative_enrolled,1',
            'pre_trained_martial' => 'required',
            'pre_martial_style' => 'required_if:pre_trained_martial,1',
            'info_source' => 'required',
            'emirates_id_expiry' => 'required',
            'pre_trained_martial' => 'required',
            // 'parent_name' => 'parent_required_if_minor:dob|max:60',
            // 'parent_phone' => 'parent_required_if_minor:dob|max:15',
            // 'parent_occupation' => 'parent_required_if_minor:dob|max:60',

        ];

        $dob = $this->dob; 
        $today = now();
        if (strtotime($dob) !== false) {
            // Parse 'dob' using Carbon
            $age = $today->diffInYears(\Carbon\Carbon::parse($dob));
        
            // Your code with $dobDate

        if( $age < 18){ 
            $rules['parent_name'] = 'required|string|max:60';
            $rules['parent_phone'] = 'required|string|max:15';
            $rules['parent_occupation'] = 'required|string|max:60';
        }

        }

        $routeName = $this->route()->getName();
        if ($routeName == 'profile.update') {
            $user_id = auth()->user()->id ;
        }
        elseif ($routeName == 'application.store') {
            $user_id = "";
        }
        elseif ($routeName == 'students.store') {
            $user_id = "";
        }
        else{
            $user_id = $this->route('user')->getKey();
        }


        return match ($this->getMethod()) {

            // $request->validate([
            //     'first_name' => 'required|string|max:255',
            //     'email' => 'required|email|max:255|unique:users,email,' .auth()->user()->id ,
            // ]);

                 
            'POST' => [
                     'passport_number' => 'nullable|regex:/^[A-Z0-9]{6,}$/|unique:students,passport_number',
                     'emirates_id' => 'required|unique:students,emirates_id',
                     'email' => 'required|email|unique:users,email',
                ] + $rules,
            'PUT', 'PATCH' => [

                    'email' => 'required|email|unique:users,email,'.$user_id,
                    'emirates_id' => 'required|unique:students,emirates_id,'.$user_id.',user_id',

                    // 'emirates_id' => 'required|unique:students,emirates_id,'.$user_id,
                    'passport_number' => 'nullable|regex:/^[A-Z0-9]{6,}$/|unique:students,passport_number,'.$user_id.',user_id',

                    // 'passport_number' => [
                    //     'nullable|regex:/^[A-Z0-9]{6,}$/',
                    //     Rule::unique('students', 'passport_number')->ignore($this->route('student')),
                    // ],
                    // 'passport_number' => [
                    //     Rule::unique('students', 'passport_number')->ignore($this->route('student')),
                    // ],
                ] + $rules,
            default => []
        };
        // return match ($this->getMethod()) {
        //     'POST' => [
        //             // 'some_field'=> 'required',
        //         ] + $rules,
        //     'PUT', 'PATCH' => [
        //             //  'some_field' => 'nullable',
        //         ] + $rules,
        //     default => []
        // };
    }

    
    public function getUserData() :array
    {
        $data = [];

        if($this->application){
            //Request from student
        }else{
            $this->password = "Test@123";
            $data['password_plain'] =  $this->password;
            $data['password'] = Hash::make($this->password);
        }
        // $lastUserId = User::latest('id')->first()->id;
        // $data['user_name'] =  "kal-". strtoupper( Str::random(2).$lastUserId+1 ) ;

        $data['first_name'] = $this->first_name;
        $data['last_name'] = $this->last_name;
        $data['gender'] = $this->gender;
        $data['phone_code'] =  $this->phone_code;
        $data['phone_number'] =  $this->phone_number;
        $data['email'] =  $this->email;
        $data['user_type'] =  Role::USER_TYPE_STUDENT;
       
        $data['weight'] =  $this->weight ;
        $data['blood_group'] =  $this->blood_group ;
        if ($this->filled('joining_date')) { 
        $data['joining_date'] =  $this->joining_date ;
        }else{
            $data['joining_date'] =  now();
        }       
        
        $data['dob'] =  $this->dob ;
        $data['email_verified_at'] = now() ;
        
        // $data['ID_Number'] =  $this->ID_Number ;

        $data['occupation'] =  $this->occupation ;
        $data['country_id'] =  $this->country_id ;
        $data['creator_id'] =  (auth()->user() ? auth()->user()->id : null ) ;
        

        if (!$this->filled('status_id')) { 
            $data['status_id'] = 1 ;
        }else{
            $data['status_id'] = $this->status_id ;
        }
        //Avoid password field here as it is computed separately
        return $data ;
    }
    public function getStudentData()
    {
        $data = [];
        $data['residency_phone'] =  $this->residency_phone ;
        $data['emergency_contact'] =  $this->emergency_contact ;
        $data['emergency_contact_2'] =  $this->emergency_contact_2 ;
        $data['po_box'] =  $this->po_box ;
        $data['parent_name'] =  $this->parent_name ;
        $data['parent_occupation'] =  $this->parent_occupation ;
        $data['parent_phone'] =  $this->parent_phone ;
        $data['relative_enrolled'] =  $this->relative_enrolled ;
        if($this->relative_enrolled){
            $data['relative_name'] =  $this->relative_name ;
        }else{
            $data['relative_name'] =  null ;
        }
        $data['pre_trained_martial'] =  $this->pre_trained_martial ;
        if($this->pre_trained_martial){
            $data['pre_martial_style'] =  $this->pre_martial_style ;
        }else{
            $data['pre_martial_style'] =  null ;
        }
        $data['info_source'] =  json_encode($this->info_source) ;

        $data['passport_expiry'] =  $this->passport_expiry ;
        $data['passport_number'] =  $this->passport_number ;

        
        $data['emirates_id'] =  $this->emirates_id ;
        $data['emirates_id_expiry'] =  $this->emirates_id_expiry ;
        $data['kacha_id'] =  1 ;
        
        //Avoid password field here as it is computed separately
        return $data ;
    }
    
}
