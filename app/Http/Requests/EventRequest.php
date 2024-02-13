<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Carbon\Carbon;
class EventRequest extends FormRequest
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
            'title' => 'required|string|max:250',
            'address' =>  'required|string|max:250',
            'event_date' => 'max:10',
            'event_time' => 'string|max:10',
            'visibility' => 'string|max:1',
            'status_id' => 'string|max:1',
            'description' =>'string|max:1000',
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
        if ($this->filled('event_time')) { 
            $data['event_time'] =  Carbon::parse($this->event_time)->format('H:i:s');
        }
        return $data + $this->validated() ;
    }
}
