<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Header Halaman -->
            <div class="glass-card p-6 md:p-8 rounded-3xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4 shadow-xl">
                <div>
                    <span class="text-xs px-3 py-1 rounded-full bg-blue-500/10 text-blue-600 dark:text-blue-400 font-semibold border border-blue-500/20">
                        Pusat Arsip Akademik
                    </span>
                    <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white mt-2">
                        Pilih Rekapitulasi Nilai Mata Pelajaran
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        Silakan pilih kelas dan mata pelajaran di bawah ini untuk melihat lembar rekapitulasi dan mencetak laporan.
                    </p>
                </div>
                <div>
                    <a href="{{ route('guru.dashboard') }}" class="px-4 py-2.5 rounded-xl bg-slate-500/10 hover:bg-slate-500/20 text-slate-700 dark:text-slate-300 text-xs font-semibold transition-all inline-flex items-center space-x-2">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Kembali ke Dashboard</span>
                    </a>
                </div>
            </div>

            <!-- Daftar Kartu Pilihan Kelas & Mapel -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($assignments as $assignment)
                    <div class="glass-card p-6 rounded-3xl shadow-xl space-y-4 flex flex-col justify-between border border-slate-200/60 dark:border-slate-800/60 hover:border-blue-500/40 transition-all">
                        <div class="space-y-3">
                            <div class="flex justify-between items-start">
                                <span class="text-xs px-3 py-1 rounded-full bg-slate-500/10 text-slate-700 dark:text-slate-300 font-bold border border-slate-500/20">
                                    {{ $assignment->schoolClass->name }}
                                </span>
                                <span class="text-[10px] px-2.5 py-1 rounded-full font-bold bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-500/20">
                                    Siap Cetak
                                </span>
                            </div>
                            <div>
                                <h3 class="text-base font-extrabold text-slate-900 dark:text-white uppercase">
                                    {{ $assignment->subject->name }}
                                </h3>
                                <p class="text-[11px] text-slate-500 font-mono mt-0.5">Kode Mapel: {{ $assignment->subject->code ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="pt-2">
                            <a href="{{ route('guru.nilai.rekap', [$assignment->class_id, $assignment->subject_id]) }}" class="w-full py-3 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold shadow-lg shadow-blue-600/20 transition-all flex items-center justify-center space-x-2">
                                <i class="fa-solid fa-file-lines"></i>
                                <span>Buka Lembar Rekap</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center glass-card rounded-3xl">
                        <i class="fa-solid fa-triangle-exclamation text-3xl text-amber-500 mb-3"></i>
                        <p class="text-slate-500 text-sm italic">Belum ada data penugasan kelas untuk mata pelajaran.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>