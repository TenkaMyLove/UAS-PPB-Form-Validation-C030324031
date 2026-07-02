<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function form()
    {
        $user = auth()->user();
        return view('contacts.form', compact('user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'    => ['required', 'string', 'min:3', 'max:100'],
            'email'   => ['required', 'email', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'telp'    => ['required', 'regex:/^[0-9]{8,15}$/'],
            'pesan'   => ['required', 'string', 'min:10', 'max:5000'],
        ], [
            'nama.required'    => 'Nama tidak boleh kosong.',
            'nama.min'         => 'Nama minimal 3 karakter.',
            'email.required'   => 'Email tidak boleh kosong.',
            'email.email'      => 'Format email tidak valid.',
            'website.url'      => 'Format URL tidak valid.',
            'telp.required'    => 'No. HP tidak boleh kosong.',
            'telp.regex'       => 'Nomor HP hanya boleh angka, 8-15 digit.',
            'pesan.required'   => 'Pesan tidak boleh kosong.',
            'pesan.min'        => 'Pesan minimal 10 karakter.',
        ]);

        Contact::create([
            'user_id'    => auth()->id(),
            'nama'       => $validated['nama'],
            'email'      => $validated['email'],
            'website'    => $validated['website'] ?? null,
            'telp'       => $validated['telp'],
            'pesan'      => $validated['pesan'],
            'status'     => 'unread',
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('contacts.form')
            ->with('success', 'Pesan berhasil dikirim. Terima kasih!');
    }
}
