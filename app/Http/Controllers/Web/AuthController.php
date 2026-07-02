<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return Auth::user()->role === 'admin'
                ? redirect()->route('admin.contacts.index')
                : redirect()->route('contacts.form');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return Auth::user()->role === 'admin'
                ? redirect()->route('admin.contacts.index')
                : redirect()->route('contacts.form');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('contacts.form');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'min:3', 'max:100'],
            'email'    => ['required', 'email:rfc,dns', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'website'  => ['nullable', 'url', 'max:255'],
            'telp'     => ['nullable', 'regex:/^[0-9]{8,15}$/'],
        ], [
            'name.required'     => 'Nama tidak boleh kosong.',
            'name.min'          => 'Nama minimal 3 karakter.',
            'email.required'    => 'Email tidak boleh kosong.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah terdaftar.',
            'password.required' => 'Password tidak boleh kosong.',
            'password.confirmed'=> 'Konfirmasi password tidak cocok.',
            'password.min'      => 'Password minimal 8 karakter.',
            'website.url'       => 'Format URL tidak valid.',
            'telp.regex'        => 'Nomor HP hanya boleh angka, 8-15 digit.',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'website'  => $validated['website'] ?? null,
            'telp'     => $validated['telp'] ?? null,
            'role'     => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('contacts.form')
            ->with('success', 'Registrasi berhasil!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
