@extends('layouts.app')

@section('title', 'Pesan Masuk')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border">
    <div class="p-6 border-b">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-[#1B3A5C]">Pesan Masuk</h1>
            <span class="text-sm text-gray-500">{{ $contacts->total() }} pesan</span>
        </div>

        <div class="flex gap-2 mt-4">
            <a href="/admin/pesan"
                class="px-3 py-1.5 text-sm rounded-lg font-medium transition {{ !$status ? 'bg-[#1B3A5C] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Semua
            </a>
            <a href="/admin/pesan?status=unread"
                class="px-3 py-1.5 text-sm rounded-lg font-medium transition {{ $status === 'unread' ? 'bg-[#1B3A5C] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Unread
            </a>
            <a href="/admin/pesan?status=read"
                class="px-3 py-1.5 text-sm rounded-lg font-medium transition {{ $status === 'read' ? 'bg-[#1B3A5C] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Read
            </a>
            <a href="/admin/pesan?status=replied"
                class="px-3 py-1.5 text-sm rounded-lg font-medium transition {{ $status === 'replied' ? 'bg-[#1B3A5C] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Replied
            </a>
        </div>
    </div>

    @if($contacts->isEmpty())
        <div class="p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
            </svg>
            <p class="mt-3 text-gray-500">Tidak ada pesan.</p>
        </div>
    @else
        <div class="divide-y">
            @foreach($contacts as $contact)
                <a href="/admin/pesan/{{ $contact->id }}"
                    class="block px-6 py-4 hover:bg-gray-50 transition">
                    <div class="flex items-center gap-3">
                        @if($contact->status === 'unread')
                            <span class="w-2.5 h-2.5 rounded-full bg-[#1B3A5C] shrink-0"></span>
                        @elseif($contact->status === 'read')
                            <span class="w-2.5 h-2.5 rounded-full bg-gray-400 shrink-0"></span>
                        @else
                            <span class="w-2.5 h-2.5 rounded-full bg-green-600 shrink-0"></span>
                        @endif

                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-sm">{{ $contact->nama }}</span>
                                @if($contact->status === 'unread')
                                    <span class="px-2 py-0.5 text-xs font-medium rounded bg-[#1B3A5C]/10 text-[#1B3A5C]">Unread</span>
                                @elseif($contact->status === 'read')
                                    <span class="px-2 py-0.5 text-xs font-medium rounded bg-gray-100 text-gray-500">Read</span>
                                @else
                                    <span class="px-2 py-0.5 text-xs font-medium rounded bg-green-50 text-green-700">Replied</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-500 truncate">{{ $contact->pesan }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $contact->email }}</p>
                        </div>

                        <span class="text-xs text-gray-400 shrink-0">{{ $contact->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="p-4 border-t">
            {{ $contacts->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
