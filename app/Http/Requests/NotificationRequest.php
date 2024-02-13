<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use App\Models\Status ;

class NotificationRequest extends FormRequest
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
            'notification_type' => 'required|integer',
            'status_id' => 'required|integer',
            'event_id' => 'nullable|exists:events,id',
            'title' => 'required|string',
            'message' => 'required|string'
        ];

        // if (!$this->filled('event_id')) { 
        //     $rules['message'] = 'required|string';
        // }
        if ($this->filled('schedule_later') && $this->schedule_later =="on") { 
            $this->schedule_later = true ;
            $rules['notification_date'] = 'required|date';  
        }else{
            $this->schedule_later = false ; 
        }

        $rules['users'] = 'required|array|min:1'; // At least one user is required
    
        // 'en.other_skills_gained' => [function (string $attribute, mixed $value, Closure $fail) {
        //     if (request()->skills_gained && in_array('Other', request()->skills_gained) && !$value && in_array(request()->lang, ['en', 'both'])) {
        //         $fail(__("Other skills in english is required."));
        //     }
        // }],

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

        // Create a new notification
        $data = [
            'title' =>$this->title ,
            'message' =>$this->message , 
            'notification_type' =>$this->notification_type ,
            'status_id' =>$this->status_id ,
            'notification_date' =>$this->notification_date ,
            'schedule_later' => $this->schedule_later ,
        ];
        if (  $this->schedule_later  == false   && ( $this->status_id == Status::STATUS_PUBLISHED  )  ) { 
            $data['notification_date'] = now();
        }
        return $data + Arr::except($this->validated(), ['event_id']); ;
    }
}
