<?php

namespace App\Http\Requests\SuperAdmin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isSuperAdmin() === true;
    }

    public function rules(): array
    {
        $admin = $this->route('admin');

        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'string',
                'email',
                'max:150',
                Rule::unique('users', 'email')->ignore($admin),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'wilayah_id' => ['required', 'integer', 'exists:wilayah,id'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }
}
