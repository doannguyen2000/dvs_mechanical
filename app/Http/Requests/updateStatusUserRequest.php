<?php

namespace App\Http\Requests;

use App\Rules\ExistsInTable;
use Illuminate\Foundation\Http\FormRequest;

class updateStatusUserRequest extends FormRequest
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
            'status' => ['required', 'boolean'],
            'item_ids' => ['required', new ExistsInTable('users', 'id')],
        ];
    }
}
