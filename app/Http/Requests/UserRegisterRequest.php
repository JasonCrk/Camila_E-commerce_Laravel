<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'unique:users', 'max:30', 'min:3'],
            'first_name' => ['required', 'max:40', 'min:3'],
            'last_name' => ['required', 'max:40', 'min:3'],
            'phone_number' => ['required', 'regex:/^\d{3}-\d{3}-\d{3}$/i'],
            'email' => ['required', 'unique:users', 'email:rfc'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
            ]
        ];
    }
}
