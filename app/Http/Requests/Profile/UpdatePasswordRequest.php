<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string', 'current_password'],
            'password'         => ['required', 'string', 'confirmed', Password::min(8)],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required'      => 'Password lama tidak boleh kosong.',
            'current_password.current_password' => 'Password lama tidak sesuai.',
            'password.required'              => 'Password baru tidak boleh kosong.',
            'password.confirmed'             => 'Konfirmasi password baru tidak cocok.',
            'password.min'                   => 'Password baru minimal 8 karakter.',
        ];
    }
}
