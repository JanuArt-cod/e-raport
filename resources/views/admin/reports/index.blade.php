<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="glass-card p-6 rounded-3xl flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-xl font-bold text-slate-900 dark:text-white flex items-center">
                        <i class="fa-solid fa-file-invoice text-emerald-600 dark:text-emerald-400 mr-2.5"></i> Rekapitulasi & Cetak Rapor ASTS
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Pilih rombongan belajar untuk memantau rekap nilai dan mencetak rapor siswa.</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2.5 rounded-xl bg-slate-500/10 hover:bg-slate-500/20 text-slate-700 dark:text-slate-300 text-xs font-semibold transition-all flex items-center space-x-2">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($classes as $c)
                    <div class="glass-card p-6 rounded-3xl flex flex-col justify-between transition-all duration-300 hover:glow-effect group">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <span class="px-3 py-1 rounded-xl bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 border border-cyan-500/20 font-bold text-xs">
                                    Rombel Kelas
                                </span>
                                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-school"></i>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white">Kelas {{ $c->name }}</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Jumlah Siswa: {{ $c->students_count }} Peserta Didik</p>
                        </div>

                        <div class="mt-6 pt-4 border-t border-slate-200/60 dark:border-slate-800/60 flex items-center justify-end">
                            <a href="{{ route('admin.reports.class-detail', $c->id) }}" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white text-xs font-semibold shadow-md shadow-emerald-600/20 transition-all flex items-center space-x-1.5">
                                <span>Buka Rekap Kelas</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 glass-card p-12 rounded-3xl text-center text-slate-500">
                        <p class="text-sm">Belum ada data rombongan belajar yang terdaftar.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>