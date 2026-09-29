<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('school.name', 'e-Rapor ASTS') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Script Inisialisasi Tema Awal -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="font-sans bg-slate-100 dark:bg-slate-950 text-slate-800 dark:text-slate-100 antialiased min-h-screen relative overflow-x-hidden flex flex-col justify-between transition-colors duration-300">

    <!-- Efek Cahaya Latar Belakang (Green & Teal Ambient Glow Blobs) -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-emerald-500/10 dark:bg-emerald-600/25 rounded-full blur-3xl pointer-events-none animate-pulse"></div>
    <div class="absolute bottom-10 right-1/4 w-96 h-96 bg-teal-500/10 dark:bg-teal-600/20 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

    <!-- Header / Navbar Glass Glow untuk Pengguna yang Sudah Login -->
    <header class="w-full px-6 md:px-8 py-4 glass-card border-x-0 border-t-0 sticky top-0 z-50 flex items-center justify-between">
        
        <!-- Sisi Kiri: Logo & Identitas Sekolah -->
        <div class="flex items-center space-x-3">
            @if(config('school.logo'))
                <img src="{{ asset(config('school.logo')) }}" alt="Logo Sekolah" class="w-10 h-10 rounded-xl object-cover glow-effect">
            @else
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center glow-effect animate-float">
                    <i class="fa-solid fa-graduation-cap text-slate-950 text-lg font-bold"></i>
                </div>
            @endif

            <div>
                <span class="font-bold text-sm md:text-base tracking-wide bg-gradient-to-r from-emerald-600 to-teal-600 dark:from-emerald-300 dark:to-teal-300 bg-clip-text text-transparent block leading-tight">
                    {{ config('school.name') }}
                </span>
                <span class="text-[10px] text-slate-500 dark:text-slate-400 tracking-wider uppercase font-medium">
                    {{ auth()->user()->role ? 'Portal ' . ucfirst(auth()->user()->role) : 'Sistem e-Rapor' }}
                </span>
            </div>
        </div>

        <!-- Sisi Kanan: Info Akun, Dark Mode Toggle, & Tombol Logout -->
        <div class="flex items-center space-x-3 md:space-x-4">
            
            <!-- Nama & Email Pengguna -->
            <div class="hidden sm:flex flex-col text-right">
                <span class="text-xs font-bold text-slate-800 dark:text-slate-200">{{ auth()->user()->name }}</span>
                <span class="text-[10px] text-emerald-600 dark:text-emerald-400 font-medium">{{ auth()->user()->email }}</span>
            </div>

            <!-- Tombol Toggle Dark/Light Mode -->
            <button id="theme-toggle" onclick="toggleTheme()" class="w-10 h-10 rounded-xl glass-card flex items-center justify-center text-emerald-600 dark:text-emerald-400 hover:text-emerald-500 transition-all cursor-pointer shadow-sm" title="Ubah Tema">
                <i id="theme-icon" class="fa-solid fa-moon"></i>
            </button>

            <!-- Tombol Keluar (Logout) -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-3.5 py-2 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/30 text-rose-600 dark:text-rose-400 text-xs font-semibold transition-all flex items-center space-x-1.5" title="Keluar Sistem">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    <span class="hidden md:inline">Keluar</span>
                </button>
            </form>

        </div>
    </header>

    <!-- Konten Utama Dashboard Dinamis -->
    <main class="flex-grow container mx-auto px-4 py-8 z-10 max-w-7xl">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="w-full text-center py-6 text-xs text-slate-500 dark:text-slate-500 z-10 border-t border-slate-200 dark:border-slate-900">
        &copy; 2026 {{ config('school.name') }}. Green Glass Glow Edition.
    </footer>

    <!-- Script Toggle Theme -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const iconEl = document.getElementById('theme-icon');
            if (document.documentElement.classList.contains('dark')) {
                iconEl.className = 'fa-solid fa-moon text-emerald-400';
            } else {
                iconEl.className = 'fa-solid fa-sun text-amber-500';
            }
        });

        function toggleTheme() {
            const htmlEl = document.documentElement;
            const iconEl = document.getElementById('theme-icon');
            
            if (htmlEl.classList.contains('dark')) {
                htmlEl.classList.remove('dark');
                localStorage.theme = 'light';
                iconEl.className = 'fa-solid fa-sun text-amber-500';
            } else {
                htmlEl.classList.add('dark');
                localStorage.theme = 'dark';
                iconEl.className = 'fa-solid fa-moon text-emerald-400';
            }
        }
    </script>
</body>
</html>