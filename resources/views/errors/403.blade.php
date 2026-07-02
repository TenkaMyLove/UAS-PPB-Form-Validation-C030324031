@extends('layouts.app')

@section('title', 'Akses Ditolak')

@section('content')
<div class="max-w-md mx-auto text-center py-16">
    <div class="text-6xl font-bold text-red-500 mb-4">403</div>
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Akses Ditolak</h1>
    <p class="text-gray-500 mb-6">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
    <a href="/" class="inline-block bg-[#1B3A5C] text-white px-6 py-2.5 rounded-lg font-medium hover:bg-[#152d47] transition">
        Kembali ke Beranda
    </a>
</div>
@endsection
