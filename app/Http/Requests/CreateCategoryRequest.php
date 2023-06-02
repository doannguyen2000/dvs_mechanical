<?php

namespace App\Http\Requests;

use App\Helpers\DatabaseHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCategoryRequest extends FormRequest
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
            'category_name' => ['required', 'string', 'max:50', Rule::unique('categories', 'category_name')],
            'category_description' => ['required', 'string', 'max:2000'],
            'status' => ['nullable', Rule::in(['', 'on'])],
            'table_name' => ['required', 'string', 'max:255', Rule::in(DatabaseHelper::getTables())],

        ];
    }
}
