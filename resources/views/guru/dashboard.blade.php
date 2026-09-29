<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Banner Sambutan Guru -->
            <div class="glass-card p-8 rounded-3xl relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <span class="text-xs uppercase tracking-wider px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 font-semibold">
                            Portal Guru Mata Pelajaran
                        </span>
                        <h1 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mt-2">
                            Selamat Datang, {{ auth()->user()->name }}! 👨‍🏫
                        </h1>
                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                            Pilih kelas dan mata pelajaran di bawah ini untuk mulai menginput nilai Asesmen Sumatif Tengah Semester (ASTS).
                        </p>
                    </div>
                </div>
            </div>

            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                     class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-xs font-medium flex items-center justify-between shadow-lg backdrop-blur-md transition-all">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-7 h-7 rounded-xl bg-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400"><i class="fa-solid fa-circle-check text-sm"></i></div>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-emerald-500 hover:text-emerald-400 p-1 cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif

            <!-- Daftar Penugasan Mengajar (Cards) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($assignments as $assignment)
                    <div class="glass-card p-6 rounded-3xl flex flex-col justify-between transition-all duration-300 hover:glow-effect group">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="px-3 py-1 rounded-full bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 border border-cyan-500/20 font-bold text-xs">
                                    Kelas {{ $assignment->schoolClass->name ?? '-' }}
                                </span>
                                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-book-open"></i>
                                </div>
                            </div>

                            <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                                {{ $assignment->subject->name ?? '-' }}
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-mono">
                                Kode Mapel: {{ $assignment->subject->code ?? '-' }}
                            </p>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-200/60 dark:border-slate-800/60 flex items-center justify-between">
                            <span class="text-[11px] text-slate-400">Status: Siap Input</span>
                            <a href="{{ route('guru.nilai.input', [$assignment->class_id, $assignment->subject_id]) }}" class="px-4 py-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white text-xs font-semibold shadow-md shadow-emerald-600/20 transition-all flex items-center space-x-1.5">
                                <span>Input Nilai</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 glass-card p-12 rounded-3xl text-center text-slate-500 dark:text-slate-400">
                        <i class="fa-solid fa-folder-open text-4xl mb-3 text-slate-400"></i>
                        <p class="text-sm">Belum ada penugasan mengajar yang diatur oleh Administrator untuk akun Anda.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>