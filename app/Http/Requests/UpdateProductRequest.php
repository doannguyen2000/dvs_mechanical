<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Rules\ExistsInTable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
            'product_name' => ['required', 'string', 'max:50'],
            'product_price' => ['required', 'numeric', 'min:10000'],
            'product_sale' => ['required', 'numeric', 'min:0', 'max:100'],
            'product_description' => ['nullable', 'string', 'max:3000'],
            'product_status' => ['nullable', 'boolean'],
            'product_type_code' => ['nullable', new ExistsInTable('product_types', 'product_type_code')],
            'product_image_ids' => ['nullable', 'array', Rule::exists('product_images', 'id')],
            'product_new_images' => ['nullable', 'array'],
            'product_new_images.*' => ['required', 'image', 'max:2048']
        ];
    }
}
