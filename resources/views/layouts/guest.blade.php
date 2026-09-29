<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('school.name') }} - {{ config('school.tagline') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Script Inisialisasi Tema -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="font-sans bg-slate-100 dark:bg-slate-950 text-slate-800 dark:text-slate-100 antialiased min-h-screen relative overflow-x-hidden flex flex-col justify-between transition-colors duration-300">

    <!-- Efek Cahaya Latar Belakang (Disesuaikan untuk Light & Dark) -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-emerald-500/10 dark:bg-emerald-600/25 rounded-full blur-3xl pointer-events-none animate-pulse"></div>
    <div class="absolute bottom-10 right-1/4 w-96 h-96 bg-teal-500/10 dark:bg-teal-600/20 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

    <!-- Header Logo Dinamis & Toggle Dark Mode -->
    <header class="w-full px-8 py-4 glass-card border-x-0 border-t-0 sticky top-0 z-50 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            @if(config('school.logo'))
                <img src="{{ asset(config('school.logo')) }}" alt="Logo Sekolah" class="w-10 h-10 rounded-xl object-cover glow-effect">
            @else
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center glow-effect animate-float">
                    <i class="fa-solid fa-graduation-cap text-slate-950 text-lg font-bold"></i>
                </div>
            @endif

            <div>
                <span class="font-bold text-base md:text-lg tracking-wide bg-gradient-to-r from-emerald-600 to-teal-600 dark:from-emerald-300 dark:to-teal-300 bg-clip-text text-transparent block leading-tight">
                    {{ config('school.name') }}
                </span>
                <span class="text-[10px] text-slate-500 dark:text-slate-400 tracking-wider uppercase font-medium">
                    {{ config('school.tagline') }}
                </span>
            </div>
        </div>

        <div class="flex items-center space-x-4">
            <!-- Tombol Toggle Dark/Light Mode -->
            <button id="theme-toggle" onclick="toggleTheme()" class="w-10 h-10 rounded-xl glass-card flex items-center justify-center text-emerald-600 dark:text-emerald-400 hover:text-emerald-500 transition-all cursor-pointer shadow-sm" title="Ubah Tema">
                <i id="theme-icon" class="fa-solid fa-moon"></i>
            </button>

            <span class="text-xs px-3 py-1.5 rounded-full bg-emerald-500/10 dark:bg-emerald-500/20 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 font-medium hidden sm:inline-block">
                <i class="fa-solid fa-circle text-[8px] text-emerald-500 mr-1.5 animate-ping"></i> Sistem Aktif
            </span>
        </div>
    </header>

    <!-- Konten Utama -->
    <main class="flex-grow flex flex-col items-center justify-center px-4 py-12 z-10">
        <div class="w-full sm:max-w-md px-8 py-8 glass-card rounded-3xl shadow-2xl transition-all duration-300 hover:glow-effect">
            {{ $slot }}
        </div>
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