<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

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
            'username' => ['nullable', 'string', 'max:80', 'unique:users,username'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'role_id' => ['required', 'string', 'exists:roles,id'],
            // No password here: the user sets it themselves through the activation link.
            'platform_access' => ['required', 'string', 'in:web,mobile,both'],
            'site_ids' => ['sometimes', 'array'],
            'site_ids.*' => ['string', 'exists:sites,id'],
        ];
    }
}
