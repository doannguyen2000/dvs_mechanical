<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:30'],
            'last_name' => ['required', 'string', 'max:60'],
            'province' => ['required', 'string', 'max:60'],
            'district' => ['required', 'string', 'max:60'],
            'ward' => ['required', 'string', 'max:60'],
            'name' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'max:100', Rule::unique('users', 'email')->ignore(request()->id)],
            'date_of_birth' => ['required', 'date_format:Y-m-d'],
            'phone' => ['required', 'string', 'regex:/^\d{10}$/'],
            'file_avatar' => ['nullable', 'file'],
        ];
    }
}
