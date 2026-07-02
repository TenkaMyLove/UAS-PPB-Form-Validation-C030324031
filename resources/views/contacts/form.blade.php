@extends('layouts.app')

@section('title', 'Form Kontak')

@section('content')
<div class="max-w-lg mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border p-8">
        <h1 class="text-2xl font-bold text-[#1B3A5C] mb-2">Kirim Pesan</h1>
        <p class="text-gray-500 mb-6">Isi form berikut untuk mengirim pesan kepada admin.</p>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/kontak">
            @csrf
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $user->name ?? '') }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#1B3A5C] focus:border-transparent outline-none transition">
                @error('nama')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#1B3A5C] focus:border-transparent outline-none transition">
                @error('email')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Website <span class="text-gray-400">(opsional)</span></label>
                <input type="url" id="website" name="website" value="{{ old('website', $user->website ?? '') }}"
                    placeholder="https://"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#1B3A5C] focus:border-transparent outline-none transition">
                @error('website')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="telp" class="block text-sm font-medium text-gray-700 mb-1">No. HP</label>
                <input type="tel" id="telp" name="telp" value="{{ old('telp', $user->telp ?? '') }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#1B3A5C] focus:border-transparent outline-none transition">
                @error('telp')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="pesan" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                <textarea id="pesan" name="pesan" rows="4" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#1B3A5C] focus:border-transparent outline-none transition resize-none">{{ old('pesan') }}</textarea>
                @error('pesan')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-[#1B3A5C] text-white py-2.5 rounded-lg font-semibold hover:bg-[#152d47] transition">
                Kirim Pesan
            </button>
        </form>
    </div>
</div>
@endsection
