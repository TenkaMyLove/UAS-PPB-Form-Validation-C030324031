@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="max-w-lg mx-auto">
    <div class="mb-4">
        <a href="/profil" class="text-sm text-[#1B3A5C] hover:underline">&larr; Kembali ke profil</a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border p-8">
        <h1 class="text-2xl font-bold text-[#1B3A5C] mb-6">Edit Profil</h1>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/profil">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#1B3A5C] focus:border-transparent outline-none transition">
                @error('name')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Website <span class="text-gray-400">(opsional)</span></label>
                <input type="url" id="website" name="website" value="{{ old('website', Auth::user()->website) }}"
                    placeholder="https://"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#1B3A5C] focus:border-transparent outline-none transition">
                @error('website')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="telp" class="block text-sm font-medium text-gray-700 mb-1">No. HP <span class="text-gray-400">(opsional)</span></label>
                <input type="tel" id="telp" name="telp" value="{{ old('telp', Auth::user()->telp) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-[#1B3A5C] focus:border-transparent outline-none transition">
                @error('telp')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-[#1B3A5C] text-white py-2.5 rounded-lg font-semibold hover:bg-[#152d47] transition">
                Simpan
            </button>
        </form>
    </div>
</div>
@endsection
