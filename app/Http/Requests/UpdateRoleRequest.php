<?php

namespace App\Http\Requests;

use App\Helpers\ValidatorHelper;
use App\Models\Role;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $role = Role::find(request()->id);
        return [
            'role_name' => ['required', 'string', 'max:20', Rule::unique('roles', 'role_name')->ignore(request()->id)],
            'role_icon' => ['required', 'string'],
        ];
    }
}
