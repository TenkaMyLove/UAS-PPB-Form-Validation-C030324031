<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Semua orang boleh mengirim kontak (guest maupun user login)
        return true;
    }

    public function rules(): array
    {
        return [
            'nama'    => ['required', 'string', 'min:3', 'max:100'],
            'email'   => ['required', 'email:rfc', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'telp'    => ['required', 'regex:/^[0-9]{8,15}$/'],
            'pesan'   => ['required', 'string', 'min:10', 'max:5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required'  => 'Nama tidak boleh kosong.',
            'nama.min'       => 'Nama minimal :min karakter.',
            'nama.max'       => 'Nama maksimal :max karakter.',
            'email.required' => 'Email tidak boleh kosong.',
            'email.email'    => 'Format email tidak valid.',
            'website.url'    => 'URL tidak valid.',
            'telp.required'  => 'Nomor telepon tidak boleh kosong.',
            'telp.regex'     => 'Nomor HP hanya boleh angka (8-15 digit).',
            'pesan.required' => 'Pesan tidak boleh kosong.',
            'pesan.min'      => 'Pesan minimal :min karakter.',
            'pesan.max'      => 'Pesan maksimal :max karakter.',
        ];
    }
}
