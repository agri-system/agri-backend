<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            // Which client is calling: lets the server enforce per-user platform access.
            'platform' => ['required', 'string', 'in:web,mobile'],
            'device_name' => ['sometimes', 'string'],
        ];
    }
}
