<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'min:3', 'max:100'],
            'email'    => ['required', 'email:rfc,dns', 'unique:users,email', 'max:255'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
            'website'  => ['nullable', 'url', 'max:255'],
            'telp'     => ['nullable', 'regex:/^[0-9]{8,15}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Nama tidak boleh kosong.',
            'name.min'           => 'Nama minimal :min karakter.',
            'name.max'           => 'Nama maksimal :max karakter.',
            'email.required'     => 'Email tidak boleh kosong.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.required'  => 'Password tidak boleh kosong.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal 8 karakter.',
            'website.url'        => 'URL website tidak valid.',
            'telp.regex'         => 'Nomor HP hanya boleh angka (8-15 digit).',
        ];
    }
}
