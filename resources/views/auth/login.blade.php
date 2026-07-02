@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border p-8">
        <h1 class="text-2xl font-bold text-[#1B3A5C] mb-2">Selamat Datang</h1>
        <p class="text-gray-500 mb-6">Masuk ke akun Anda untuk melanjutkan.</p>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#1B3A5C] focus:border-transparent outline-none transition">
                @error('email')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#1B3A5C] focus:border-transparent outline-none transition">
                @error('password')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-[#1B3A5C] text-white py-2.5 rounded-lg font-semibold hover:bg-[#152d47] transition">
                Masuk
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            Belum punya akun?
            <a href="/register" class="text-[#1B3A5C] font-medium hover:underline">Daftar</a>
        </p>
    </div>
</div>
@endsection
