<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Carbon\Carbon;
class CategoryRequest extends FormRequest
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
            'category_label' => 'required|string|max:120',
            'category_type' =>  'required|string|max:1',
            'category_description' =>  'nullable|string|max:150',
            'status_id' =>  'required',
        ] ;
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
       
        return   $this->validated() ;
    }
}
