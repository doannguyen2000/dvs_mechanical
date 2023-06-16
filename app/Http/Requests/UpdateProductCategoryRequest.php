<?php

namespace App\Http\Requests;

use App\Rules\ExistsInTable;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductCategoryRequest extends FormRequest
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
            'item_ids' => ['nullable', new ExistsInTable('categories', 'id')],
            'item_new_ids' => ['nullable', new ExistsInTable('categories', 'id')],
        ];
    }
}
