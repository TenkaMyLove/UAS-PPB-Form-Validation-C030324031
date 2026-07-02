<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => ['sometimes', 'required', 'string', 'min:3', 'max:100'],
            'website' => ['nullable', 'url', 'max:255'],
            'telp'    => ['nullable', 'regex:/^[0-9]{8,15}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama tidak boleh kosong.',
            'name.min'      => 'Nama minimal :min karakter.',
            'website.url'   => 'URL website tidak valid.',
            'telp.regex'    => 'Nomor HP hanya boleh angka (8-15 digit).',
        ];
    }
}
