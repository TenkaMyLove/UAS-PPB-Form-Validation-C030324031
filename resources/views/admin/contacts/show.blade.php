@extends('layouts.app')

@section('title', 'Detail Pesan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-4">
        <a href="/admin/pesan" class="text-sm text-[#1B3A5C] hover:underline">&larr; Kembali ke daftar</a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border p-8">
        <div class="flex items-center gap-3 mb-6">
            @if($contact->status === 'unread')
                <span class="w-3 h-3 rounded-full bg-[#1B3A5C]"></span>
            @elseif($contact->status === 'read')
                <span class="w-3 h-3 rounded-full bg-gray-400"></span>
            @else
                <span class="w-3 h-3 rounded-full bg-green-600"></span>
            @endif
            <span class="text-sm font-bold uppercase tracking-wide
                {{ $contact->status === 'unread' ? 'text-[#1B3A5C]' : ($contact->status === 'read' ? 'text-gray-500' : 'text-green-600') }}">
                {{ $contact->status }}
            </span>
            <span class="text-xs text-gray-400 ml-auto">{{ $contact->created_at->format('d/m/Y H:i') }}</span>
        </div>

        <div class="space-y-4 mb-6">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Nama</p>
                <p class="text-sm mt-1">{{ $contact->nama }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Email</p>
                <p class="text-sm mt-1">{{ $contact->email }}</p>
            </div>
            @if($contact->website)
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Website</p>
                    <p class="text-sm mt-1">{{ $contact->website }}</p>
                </div>
            @endif
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">No. HP</p>
                <p class="text-sm mt-1">{{ $contact->telp }}</p>
            </div>
            @if($contact->ip_address)
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">IP Address</p>
                    <p class="text-sm mt-1">{{ $contact->ip_address }}</p>
                </div>
            @endif
        </div>

        <hr class="my-6">

        <div class="mb-6">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Pesan</p>
            <p class="text-sm leading-relaxed whitespace-pre-wrap">{{ $contact->pesan }}</p>
        </div>

        <div class="flex gap-3">
            @if($contact->status !== 'replied')
                <form method="POST" action="/admin/pesan/{{ $contact->id }}/status" class="flex-1">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="replied">
                    <button type="submit" class="w-full border border-[#1B3A5C] text-[#1B3A5C] py-2.5 rounded-lg font-medium hover:bg-[#1B3A5C]/5 transition text-sm">
                        Tandai Replied
                    </button>
                </form>
            @endif

            <form method="POST" action="/admin/pesan/{{ $contact->id }}" class="flex-1"
                onsubmit="return confirm('Hapus pesan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full border border-red-500 text-red-500 py-2.5 rounded-lg font-medium hover:bg-red-50 transition text-sm">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
