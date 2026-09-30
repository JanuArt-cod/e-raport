<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Banner Sambutan Admin -->
            <div class="glass-card p-8 rounded-3xl relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <span class="text-xs uppercase tracking-wider px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 font-semibold">
                            Panel Administrator
                        </span>
                        <h1 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mt-2">
                            Selamat Datang, {{ auth()->user()->name }}! 👋
                        </h1>
                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                            Kelola data master sekolah, rombongan belajar, dan pemetaan pengajar ujian ASTS di sini.
                        </p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-xs text-slate-500 dark:text-slate-400 bg-black/5 dark:bg-white/5 px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-800">
                            <i class="fa-solid fa-calendar-days text-emerald-500 mr-2"></i> Tahun Ajaran {{ \App\Models\Setting::get('academic_year', '2025/2026') }} • Semester {{ \App\Models\Setting::get('semester', 'Ganjil') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Kartu Statistik (Metrics Grid) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Card 1: Total Siswa -->
                <div class="glass-card p-6 rounded-3xl transition-all duration-300 hover:glow-effect group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Siswa</p>
                            <h3 class="text-3xl font-ext500 font-bold text-slate-900 dark:text-white mt-2">{{ $totalStudents }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 dark:bg-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-user-graduate text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-200/60 dark:border-slate-800/60 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                        <span>Terdaftar di sistem</span>
                        <span class="text-emerald-600 dark:text-emerald-400 font-medium"><i class="fa-solid fa-arrow-up mr-1"></i> Aktif</span>
                    </div>
                </div>

                <!-- Card 2: Total Guru -->
                <div class="glass-card p-6 rounded-3xl transition-all duration-300 hover:glow-effect group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Guru</p>
                            <h3 class="text-3xl font-bold text-slate-900 dark:text-white mt-2">{{ $totalTeachers }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-teal-500/10 dark:bg-teal-500/20 flex items-center justify-center text-teal-600 dark:text-teal-400 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-chalkboard-user text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-200/60 dark:border-slate-800/60 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                        <span>Pengajar Mapel & Wali</span>
                        <span class="text-teal-600 dark:text-teal-400 font-medium">Pengajar</span>
                    </div>
                </div>

                <!-- Card 3: Total Kelas -->
                <div class="glass-card p-6 rounded-3xl transition-all duration-300 hover:glow-effect group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Rombel Kelas</p>
                            <h3 class="text-3xl font-bold text-slate-900 dark:text-white mt-2">{{ $totalClasses }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-cyan-500/10 dark:bg-cyan-500/20 flex items-center justify-center text-cyan-600 dark:text-cyan-400 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-school text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-200/60 dark:border-slate-800/60 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                        <span>Kelas 7, 8, & 9</span>
                        <span class="text-cyan-600 dark:text-cyan-400 font-medium">Rombel</span>
                    </div>
                </div>

                <!-- Card 4: Mata Pelajaran -->
                <div class="glass-card p-6 rounded-3xl transition-all duration-300 hover:glow-effect group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Mata Pelajaran</p>
                            <h3 class="text-3xl font-bold text-slate-900 dark:text-white mt-2">{{ $totalSubjects }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 dark:bg-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-book-open text-xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-200/60 dark:border-slate-800/60 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                        <span>Kurikulum ASTS</span>
                        <span class="text-emerald-600 dark:text-emerald-400 font-medium">Mapel</span>
                    </div>
                </div>

            </div>

            <!-- Menu Aksi Cepat Master Data (Quick Actions) -->
            <div class="glass-card p-8 rounded-3xl">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center">
                    <i class="fa-solid fa-sliders text-emerald-500 mr-2"></i> Manajemen Master Data
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">Pilih menu di bawah ini untuk mengelola entitas data sekolah secara berkala.</p>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-4">
                    
                    <!-- 1. Data Siswa -->
                    <a href="{{ route('admin.students.index') }}" class="p-4 rounded-2xl bg-white/50 dark:bg-slate-900/40 border border-slate-200 dark:border-slate-800 hover:border-emerald-500/50 transition-all group flex flex-col justify-between">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-600 dark:text-emerald-400 mb-3 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-users-rectangle"></i>
                            </div>
                            <h4 class="font-semibold text-sm text-slate-900 dark:text-white">Data Siswa</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Tambah, edit, atau import siswa per kelas.</p>
                        </div>
                        <div class="mt-4 text-xs font-medium text-emerald-600 dark:text-emerald-400 flex items-center">
                            Kelola <i class="fa-solid fa-arrow-right ml-1.5 transform group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </a>

                    <!-- 2. Data Guru & Wali -->
                    <a href="{{ route('admin.users.index') }}" class="p-4 rounded-2xl bg-white/50 dark:bg-slate-900/40 border border-slate-200 dark:border-slate-800 hover:border-teal-500/50 transition-all group flex flex-col justify-between">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-teal-500/10 flex items-center justify-center text-teal-600 dark:text-teal-400 mb-3 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-id-card-clip"></i>
                            </div>
                            <h4 class="font-semibold text-sm text-slate-900 dark:text-white">Data Guru & Wali</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Pengaturan akun guru dan penunjukan wali kelas.</p>
                        </div>
                        <div class="mt-4 text-xs font-medium text-teal-600 dark:text-teal-400 flex items-center">
                            Kelola <i class="fa-solid fa-arrow-right ml-1.5 transform group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </a>

                    <!-- 3. Rombel Kelas -->
                    <a href="{{ route('admin.classes.index') }}" class="p-4 rounded-2xl bg-white/50 dark:bg-slate-900/40 border border-slate-200 dark:border-slate-800 hover:border-cyan-500/50 transition-all group flex flex-col justify-between">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-cyan-500/10 flex items-center justify-center text-cyan-600 dark:text-cyan-400 mb-3 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-school"></i>
                            </div>
                            <h4 class="font-semibold text-sm text-slate-900 dark:text-white">Rombel Kelas</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Daftar rombongan belajar dan wali kelas.</p>
                        </div>
                        <div class="mt-4 text-xs font-medium text-cyan-600 dark:text-cyan-400 flex items-center">
                            Kelola <i class="fa-solid fa-arrow-right ml-1.5 transform group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </a>

                    <!-- 4. Mata Pelajaran -->
                    <a href="{{ route('admin.subjects.index') }}" class="p-4 rounded-2xl bg-white/50 dark:bg-slate-900/40 border border-slate-200 dark:border-slate-800 hover:border-emerald-500/50 transition-all group flex flex-col justify-between">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-600 dark:text-emerald-400 mb-3 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-book-bookmark"></i>
                            </div>
                            <h4 class="font-semibold text-sm text-slate-900 dark:text-white">Mata Pelajaran</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Daftar mata pelajaran yang diuji saat ASTS.</p>
                        </div>
                        <div class="mt-4 text-xs font-medium text-emerald-600 dark:text-emerald-400 flex items-center">
                            Kelola <i class="fa-solid fa-arrow-right ml-1.5 transform group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </a>

                    <!-- 5. Mapping Pengajar -->
                    <a href="{{ route('admin.assignments.index') }}" class="p-4 rounded-2xl bg-white/50 dark:bg-slate-900/40 border border-slate-200 dark:border-slate-800 hover:border-teal-500/50 transition-all group flex flex-col justify-between">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-teal-500/10 flex items-center justify-center text-teal-600 dark:text-teal-400 mb-3 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-network-wired"></i>
                            </div>
                            <h4 class="font-semibold text-sm text-slate-900 dark:text-white">Mapping Pengajar</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Atur jadwal guru mengajar di tiap kelas.</p>
                        </div>
                        <div class="mt-4 text-xs font-medium text-teal-600 dark:text-teal-400 flex items-center">
                            Kelola <i class="fa-solid fa-arrow-right ml-1.5 transform group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </a>
                    <!-- Kartu Rekapitulasi & Cetak Rapor -->
                    {{-- <a href="{{ route('admin.reports.index') }}" class="p-4 rounded-2xl bg-white/50 dark:bg-slate-900/40 border border-slate-200 dark:border-slate-800 hover:border-emerald-500/50 transition-all group flex flex-col justify-between">
                        <div>
                            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-600 dark:text-emerald-400 mb-3 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                            </div>
                            <h4 class="font-semibold text-sm text-slate-900 dark:text-white">Rekap & Cetak Rapor</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Pantau matriks nilai dan cetak rapor ASTS.</p>
                        </div>
                        <div class="mt-4 text-xs font-medium text-emerald-600 dark:text-emerald-400 flex items-center">
                            Kelola <i class="fa-solid fa-arrow-right ml-1.5 transform group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </a> --}}

                </div>
            </div>

        </div>
    </div>
</x-app-layout>