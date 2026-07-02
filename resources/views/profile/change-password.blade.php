@extends('layouts.app')

@section('title', 'Ganti Password')

@section('content')
<div class="max-w-lg mx-auto">
    <div class="mb-4">
        <a href="/profil" class="text-sm text-[#1B3A5C] hover:underline">&larr; Kembali ke profil</a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border p-8">
        <h1 class="text-2xl font-bold text-[#1B3A5C] mb-2">Ganti Password</h1>
        <p class="text-gray-500 mb-6">Masukkan password lama dan password baru Anda.</p>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/profil/password">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
                <input type="password" id="current_password" name="current_password" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#1B3A5C] focus:border-transparent outline-none transition">
                @error('current_password')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                <input type="password" id="password" name="password" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#1B3A5C] focus:border-transparent outline-none transition">
                @error('password')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#1B3A5C] focus:border-transparent outline-none transition">
            </div>

            <button type="submit" class="w-full bg-[#1B3A5C] text-white py-2.5 rounded-lg font-semibold hover:bg-[#152d47] transition">
                Ganti Password
            </button>
        </form>
    </div>
</div>
@endsection
