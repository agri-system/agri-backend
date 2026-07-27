<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->route('user');

        return [
            'first_name' => ['sometimes', 'string', 'max:100'],
            'last_name' => ['sometimes', 'string', 'max:100'],
            'username' => ['sometimes', 'string', 'max:80', Rule::unique('users', 'username')->ignore($user)],
            'email' => ['sometimes', 'nullable', 'email', Rule::unique('users', 'email')->ignore($user)],
            'role_id' => ['sometimes', 'string', 'exists:roles,id'],
            'site_ids' => ['sometimes', 'array'],
            'site_ids.*' => ['string', 'exists:sites,id'],
        ];
    }
}
