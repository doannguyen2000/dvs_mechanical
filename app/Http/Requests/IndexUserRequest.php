<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'search' => ['nullable', 'string', 'max:30'],
            'select_filter_role' => ['nullable', Rule::exists('roles', 'role_code')],
            'select_filter_is_online' => ['nullable', Rule::in(['on', 'off'])],
            'paginate' => ['nullable', Rule::in([5, 10, 20, 50, 100, 0])]
        ];
    }
}
