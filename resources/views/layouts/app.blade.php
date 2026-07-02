<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kontak App')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen font-sans text-gray-800">
    <nav class="bg-[#1B3A5C] text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <a href="/" class="text-xl font-bold tracking-tight">Kontak App</a>
                <div class="flex items-center gap-4">
                    @auth
                        <span class="text-sm text-white/80">{{ Auth::user()->name }}</span>
                        @if(Auth::user()->role === 'admin')
                            <a href="/admin/pesan" class="text-sm hover:text-white/80 transition">Pesan</a>
                        @else
                            <a href="/kontak" class="text-sm hover:text-white/80 transition">Kirim Pesan</a>
                        @endif
                        <a href="/profil" class="text-sm hover:text-white/80 transition">Profil</a>
                        <form method="POST" action="/logout" class="inline">
                            @csrf
                            <button type="submit" class="text-sm hover:text-white/80 transition">Keluar</button>
                        </form>
                    @else
                        <a href="/login" class="text-sm hover:text-white/80 transition">Masuk</a>
                        <a href="/register" class="bg-white/10 px-4 py-2 rounded-lg text-sm hover:bg-white/20 transition">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="max-w-6xl mx-auto mt-4 px-4">
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-6xl mx-auto mt-4 px-4">
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <main class="max-w-6xl mx-auto px-4 py-8">
        @yield('content')
    </main>

    <footer class="border-t mt-auto py-6 text-center text-sm text-gray-500">
        UAS PPB C030324031 &copy; {{ date('Y') }}
    </footer>
</body>
</html>
