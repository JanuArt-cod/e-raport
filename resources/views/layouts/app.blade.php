<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ \App\Models\Setting::get('school_name', config('school.name', 'e-Rapor ASTS')) }}</title>

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

    <!-- Efek Cahaya Latar Belakang -->
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-emerald-500/10 dark:bg-emerald-600/25 rounded-full blur-3xl pointer-events-none animate-pulse"></div>
    <div class="absolute bottom-10 right-1/4 w-96 h-96 bg-teal-500/10 dark:bg-teal-600/20 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

    <!-- Header / Navbar Responsive 2 Baris -->
    <header class="w-full px-4 sm:px-6 md:px-8 py-3.5 glass-card border-x-0 border-t-0 sticky top-0 z-50 shadow-md">
        
        <!-- BARIS UTAMA: Identitas & Kontrol Akun -->
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
            
            <!-- Sisi Kiri: Logo & Nama Sekolah -->
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center glow-effect shrink-0">
                    <i class="fa-solid fa-graduation-cap text-slate-950 text-lg font-bold"></i>
                </div>
                <div>
                    <span class="font-bold text-xs sm:text-sm md:text-base tracking-wide bg-gradient-to-r from-emerald-600 to-teal-600 dark:from-emerald-300 dark:to-teal-300 bg-clip-text text-transparent block leading-tight truncate max-w-[200px] sm:max-w-sm">
                        {{ \App\Models\Setting::get('school_name', 'e-Rapor ASTS') }}
                    </span>
                    <span class="text-[9px] sm:text-[10px] text-slate-500 dark:text-slate-400 tracking-wider uppercase font-medium">
                        TA {{ \App\Models\Setting::get('academic_year', '2025/2026') }} • Semester {{ \App\Models\Setting::get('semester', 'Ganjil') }}
                    </span>
                </div>
            </div>

            <!-- Sisi Kanan: Profil, Tema, Logout, & Tombol Hamburger -->
            <div class="flex items-center space-x-3">
                <div class="hidden lg:flex flex-col text-right">
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200">{{ auth()->user()->name ?? 'Pengguna' }}</span>
                    <span class="text-[10px] text-emerald-600 dark:text-emerald-400 uppercase tracking-wider font-semibold">{{ auth()->user()->role ?? '' }}</span>
                </div>

                <!-- Tombol Toggle Dark/Light Mode -->
                <button id="theme-toggle" onclick="toggleTheme()" class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl glass-card flex items-center justify-center text-emerald-600 dark:text-emerald-400 hover:text-emerald-500 transition-all cursor-pointer shadow-sm" title="Ubah Tema">
                    <i id="theme-icon" class="fa-solid fa-moon"></i>
                </button>

                <!-- Tombol Logout -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-3.5 py-2 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/30 text-rose-600 dark:text-rose-400 text-xs font-semibold transition-all flex items-center space-x-1.5 cursor-pointer" title="Keluar Sistem">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span class="hidden sm:inline">Keluar</span>
                    </button>
                </form>

                <!-- Tombol Hamburger (Hanya tampil di HP / Tablet / Layar Kecil) -->
                <button onclick="toggleMobileMenu()" class="md:hidden w-9 h-9 rounded-xl glass-card flex items-center justify-center text-slate-700 dark:text-slate-300 hover:text-emerald-500 transition-all cursor-pointer">
                    <i id="mobile-menu-icon" class="fa-solid fa-bars text-base"></i>
                </button>
            </div>
        </div>

        <!-- BARIS KEDUA: Menu Navigasi Desktop (Khusus Layar MD ke atas) -->
        <nav class="hidden md:flex items-center justify-start space-x-2 mt-3 pt-3 border-t border-slate-200/60 dark:border-slate-800/60 overflow-x-auto">
            @php
                $dashboardRoute = route('dashboard');
                if (auth()->check()) {
                    $role = strtolower(auth()->user()->role ?? '');
                    if ($role === 'wali_kelas') {
                        $dashboardRoute = route('homeroom.dashboard');
                    }
                }
            @endphp

            <a href="{{ $dashboardRoute }}" class="px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('*.dashboard') || request()->routeIs('homeroom.*') ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-500/10' }} transition-all flex items-center space-x-1.5 shrink-0">
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </a>

            @if(auth()->check() && strtolower(auth()->user()->role ?? '') === 'wali_kelas')
                <a href="{{ route('homeroom.notes.index') }}" class="px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('homeroom.notes.*') ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-500/10' }} transition-all flex items-center space-x-1.5 shrink-0">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>Catatan Siswa</span>
                </a>
                
                <a href="{{ route('homeroom.ledger.index') }}" class="px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('homeroom.ledger.*') ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-500/10' }} transition-all flex items-center space-x-1.5 shrink-0">
                    <i class="fa-solid fa-table-cells"></i>
                    <span>Ledger Nilai</span>
                </a>

                <a href="{{ route('homeroom.grading.index') }}" class="px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('homeroom.grading.*') ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-500/10' }} transition-all flex items-center space-x-1.5 shrink-0">
                    <i class="fa-solid fa-list-check"></i>
                    <span>Monitoring Nilai</span>
                </a>

                <a href="{{ route('homeroom.nilai.index') }}" class="px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('homeroom.nilai.*') ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-500/10' }} transition-all flex items-center space-x-1.5 shrink-0">
                    <i class="fa-solid fa-book-open-reader"></i>
                    <span>Input Nilai Mapel</span>
                </a>
            @endif
            
            @if(auth()->check() && strtolower(auth()->user()->role ?? '') === 'guru')
                <a href="{{ route('guru.nilai.rekap.index') }}" class="px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('guru.nilai.rekap*') ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-500/10' }} transition-all flex items-center space-x-1.5 shrink-0">
                    <i class="fa-solid fa-file-lines"></i>
                    <span>Rekap Nilai</span>
                </a>
            @endif
            
            @if(auth()->check() && strtolower(auth()->user()->role ?? '') === 'admin')
                <a href="{{ route('admin.settings.index') }}" class="px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.settings.*') ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-500/10' }} transition-all flex items-center space-x-1.5 shrink-0">
                    <i class="fa-solid fa-gear"></i>
                    <span>Pengaturan</span>
                </a>

                <a href="{{ route('admin.reports.index') }}" class="px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.reports.*') ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-500/10' }} transition-all flex items-center space-x-1.5 shrink-0">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                    <span>Rekap & Cetak</span>
                </a>

                <a href="{{ route('admin.monitoring.index') }}" class="px-3 py-2 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.monitoring.*') ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-500/10' }} transition-all flex items-center space-x-1.5 shrink-0">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>Monitoring Rapor</span>
                </a>
            @endif
        </nav>

        <!-- MENU MOBILE DROPDOWN (Tampil saat ikon hamburger diklik di HP/Tablet) -->
        <div id="mobile-menu" class="hidden flex-col space-y-2 mt-3 pt-3 border-t border-slate-200/60 dark:border-slate-800/60 md:hidden">
            <div class="px-2 pb-1 text-xs font-bold text-slate-700 dark:text-slate-300">
                Login sebagai: <span class="text-emerald-600 dark:text-emerald-400 uppercase">{{ auth()->user()->name ?? '' }} ({{ auth()->user()->role ?? '' }})</span>
            </div>

            <a href="{{ $dashboardRoute }}" class="px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('*.dashboard') || request()->routeIs('homeroom.*') ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-500/10' }} transition-all flex items-center space-x-2">
                <i class="fa-solid fa-house w-4"></i>
                <span>Dashboard</span>
            </a>

            @if(auth()->check() && strtolower(auth()->user()->role ?? '') === 'wali_kelas')
                <a href="{{ route('homeroom.notes.index') }}" class="px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('homeroom.notes.*') ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-500/10' }} transition-all flex items-center space-x-2">
                    <i class="fa-solid fa-pen-to-square w-4"></i>
                    <span>Catatan Siswa</span>
                </a>
                
                <a href="{{ route('homeroom.ledger.index') }}" class="px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('homeroom.ledger.*') ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-500/10' }} transition-all flex items-center space-x-2">
                    <i class="fa-solid fa-table-cells w-4"></i>
                    <span>Ledger Nilai</span>
                </a>

                <a href="{{ route('homeroom.grading.index') }}" class="px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('homeroom.grading.*') ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-500/10' }} transition-all flex items-center space-x-2">
                    <i class="fa-solid fa-list-check w-4"></i>
                    <span>Monitoring Nilai</span>
                </a>

                <a href="{{ route('homeroom.nilai.index') }}" class="px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('homeroom.nilai.*') ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-500/10' }} transition-all flex items-center space-x-2">
                    <i class="fa-solid fa-book-open-reader w-4"></i>
                    <span>Input Nilai Mapel</span>
                </a>
            @endif
            
            @if(auth()->check() && strtolower(auth()->user()->role ?? '') === 'guru')
                <a href="{{ route('guru.nilai.rekap.index') }}" class="px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('guru.nilai.rekap*') ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-500/10' }} transition-all flex items-center space-x-2">
                    <i class="fa-solid fa-file-lines w-4"></i>
                    <span>Rekap Nilai</span>
                </a>
            @endif
            
            @if(auth()->check() && strtolower(auth()->user()->role ?? '') === 'admin')
                <a href="{{ route('admin.settings.index') }}" class="px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.settings.*') ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-500/10' }} transition-all flex items-center space-x-2">
                    <i class="fa-solid fa-gear w-4"></i>
                    <span>Pengaturan</span>
                </a>

                <a href="{{ route('admin.reports.index') }}" class="px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.reports.*') ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-500/10' }} transition-all flex items-center space-x-2">
                    <i class="fa-solid fa-file-invoice-dollar w-4"></i>
                    <span>Rekap & Cetak</span>
                </a>

                <a href="{{ route('admin.monitoring.index') }}" class="px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.monitoring.*') ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-500/10' }} transition-all flex items-center space-x-2">
                    <i class="fa-solid fa-chart-line w-4"></i>
                    <span>Monitoring Rapor</span>
                </a>
            @endif
        </div>
    </header>

    <!-- Konten Utama -->
    <main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 z-10 max-w-7xl">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="w-full text-center py-6 text-xs text-slate-500 dark:text-slate-500 z-10 border-t border-slate-200 dark:border-slate-900">
        &copy; 2026 {{ \App\Models\Setting::get('school_name', config('school.name')) }}. Green Glass Glow Edition.
    </footer>

    <!-- Script Tema & Responsive Mobile Menu -->
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

        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('mobile-menu-icon');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                menu.classList.add('flex');
                icon.className = 'fa-solid fa-xmark text-base';
            } else {
                menu.classList.remove('flex');
                menu.classList.add('hidden');
                icon.className = 'fa-solid fa-bars text-base';
            }
        }
    </script>
</body>
</html>