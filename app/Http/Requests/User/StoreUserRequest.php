<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:80', 'unique:users,username'],
            'email' => ['nullable', 'email', 'unique:users,email'],
            // optional: if omitted, the controller generates a temporary one.
            'password' => ['nullable', 'string', Password::defaults()],
            'role_id' => ['required', 'string', 'exists:roles,id'],
            'site_ids' => ['sometimes', 'array'],
            'site_ids.*' => ['string', 'exists:sites,id'],
        ];
    }
}
