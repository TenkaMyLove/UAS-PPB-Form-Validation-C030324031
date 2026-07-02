<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show');
    }

    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'min:3', 'max:100'],
            'website' => ['nullable', 'url', 'max:255'],
            'telp'    => ['nullable', 'regex:/^[0-9]{8,15}$/'],
        ], [
            'name.required' => 'Nama tidak boleh kosong.',
            'name.min'      => 'Nama minimal 3 karakter.',
            'website.url'   => 'Format URL tidak valid.',
            'telp.regex'    => 'Nomor HP hanya boleh angka, 8-15 digit.',
        ]);

        $user = $request->user();
        $user->update([
            'name'    => $validated['name'],
            'website' => $validated['website'] ?? null,
            'telp'    => $validated['telp'] ?? null,
        ]);

        return redirect()->route('profile.show')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function password()
    {
        return view('profile.change-password');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required'     => 'Password lama tidak boleh kosong.',
            'current_password.current_password' => 'Password lama tidak sesuai.',
            'password.required'             => 'Password baru tidak boleh kosong.',
            'password.confirmed'            => 'Konfirmasi password tidak cocok.',
            'password.min'                  => 'Password minimal 8 karakter.',
        ]);

        $user = $request->user();
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        $user->tokens()->delete();

        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Password berhasil diubah. Silakan login kembali.');
    }
}
