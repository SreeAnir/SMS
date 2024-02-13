<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use App\Models\Status;
class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->password = "Test@123";
        $rules = [
            'first_name' => 'required|string',
            'location_id' => 'nullable|exists:locations,id',
            'roles' => 'nullable|array',
            'roles.*' => 'required|exists:roles,id',
        ];
        return match ($this->getMethod()) {
            'POST' => [
                    'first_name'=> 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required',
                ] + $rules,
            'PUT', 'PATCH' => [
                    'first_name'=> 'required',
                    'email' => 'required|email|unique:users,email,'.$this->route('user')->getKey(),
                    // 'password' => 'nullable',
                ] + $rules,
            default => []
        };
        // dd("d");
    }

    public function getData()
    {
        $data = [];
        // dd("dsf");

        if ($this->filled('password')) { 
            $data['password_plain'] = $this->password;
            $data['password'] = Hash::make($this->password);

        }
        $data['last_name'] =  $this->last_name;
        $data['phone_code'] =  $this->phone_code;
        if (!$this->filled('status_id')) { 
            $data['status_id'] =  1;
        }
        $data['phone_number'] =  $this->phone_number;
        $data['user_type'] =  $this->user_type;
        //Avoid password field here as it is computed separately
        return $data + Arr::except($this->validated(), ['password']);
    }
}
