@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border p-8">
        <h1 class="text-2xl font-bold text-[#1B3A5C] mb-2">Buat Akun</h1>
        <p class="text-gray-500 mb-6">Daftar untuk mulai menggunakan layanan kami.</p>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/register">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#1B3A5C] focus:border-transparent outline-none transition">
                @error('name')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#1B3A5C] focus:border-transparent outline-none transition">
                @error('email')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#1B3A5C] focus:border-transparent outline-none transition">
                @error('password')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#1B3A5C] focus:border-transparent outline-none transition">
            </div>

            <div class="mb-4">
                <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Website <span class="text-gray-400">(opsional)</span></label>
                <input type="url" id="website" name="website" value="{{ old('website') }}"
                    placeholder="https://"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#1B3A5C] focus:border-transparent outline-none transition">
                @error('website')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="telp" class="block text-sm font-medium text-gray-700 mb-1">No. HP <span class="text-gray-400">(opsional)</span></label>
                <input type="tel" id="telp" name="telp" value="{{ old('telp') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#1B3A5C] focus:border-transparent outline-none transition">
                @error('telp')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-[#1B3A5C] text-white py-2.5 rounded-lg font-semibold hover:bg-[#152d47] transition">
                Daftar
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            Sudah punya akun?
            <a href="/login" class="text-[#1B3A5C] font-medium hover:underline">Masuk</a>
        </p>
    </div>
</div>
@endsection
