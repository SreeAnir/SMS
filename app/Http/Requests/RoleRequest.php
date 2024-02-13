<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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

        $rules = [
            'permissions' => 'required|array',
            'permission.*' => 'exists|permissions,id',
        ];
        return match ($this->getMethod()) {
            'POST' => [
                    'name' => 'required|string|min:2|max:15|unique:roles,name',
                ] + $rules,
            'PUT', 'PATCH' => [
                    'name' => 'required|string|min:2|max:15|unique:roles,name,'.$this->route('role')->getKey(),
                ] + $rules,
            default => []
        };

    }

    public function getData()
    {
        return $this->only(['name']) + [
                'guard_name' => 'admin', ///admin guard fix
            ];
    }
}
