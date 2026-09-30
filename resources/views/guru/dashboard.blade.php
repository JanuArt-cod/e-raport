<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Banner Sambutan -->
            <div class="glass-card p-6 md:p-8 rounded-3xl shadow-xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <span class="text-xs px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-semibold border border-emerald-500/20">
                        Portal Guru Mata Pelajaran
                    </span>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 dark:text-white mt-2">
                        Selamat Datang, {{ auth()->user()->name }}! 👩‍🏫
                    </h1>
                    <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-1">
                        Pilih kelas dan mata pelajaran di bawah ini untuk mengelola nilai Asesmen Sumatif Peserta Didik.
                    </p>
                </div>
            </div>

            <!-- Daftar Kartu Kelas & Mapel -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($assignments as $assignment)
                    <div class="glass-card p-6 rounded-3xl shadow-xl space-y-5 flex flex-col justify-between border border-slate-200/60 dark:border-slate-800/60 hover:border-emerald-500/40 transition-all">
                        
                        <!-- Header Kartu -->
                        <div class="space-y-3">
                            <div class="flex justify-between items-start">
                                <span class="text-xs px-3 py-1 rounded-full bg-slate-500/10 text-slate-700 dark:text-slate-300 font-bold border border-slate-500/20">
                                    {{ $assignment->schoolClass->name }}
                                </span>
                                <!-- Badge Status Dinamis -->
                                <span class="text-[10px] px-3 py-1 rounded-full font-bold border {{ $assignment->status_class }}">
                                    {{ $assignment->status_label }}
                                </span>
                            </div>

                            <div>
                                <h3 class="text-base font-extrabold text-slate-900 dark:text-white uppercase">
                                    {{ $assignment->subject->name }}
                                </h3>
                                <p class="text-[11px] text-slate-500 font-mono mt-0.5">Kode Mapel: {{ $assignment->subject->code ?? '-' }}</p>
                            </div>
                        </div>

                        <!-- Bagian Progres Bar -->
                        <div class="space-y-1.5 pt-3 border-t border-slate-200/60 dark:border-slate-800/60">
                            <div class="flex justify-between text-[11px] font-mono text-slate-600 dark:text-slate-400">
                                <span>Progres: {{ $assignment->graded_count }} dari {{ $assignment->total_students }} Siswa</span>
                                <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $assignment->percentage }}%</span>
                            </div>
                            <div class="w-full bg-slate-200 dark:bg-slate-700/60 rounded-full h-2.5 overflow-hidden border border-slate-300/40 dark:border-slate-700">
                                <div class="bg-emerald-500 h-full rounded-full transition-all duration-500 shadow-sm" style="width: {{ $assignment->percentage }}%;"></div>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="pt-2">
                            <a href="{{ route('guru.nilai.input', [$assignment->class_id, $assignment->subject_id]) }}" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold shadow-lg shadow-emerald-600/20 transition-all flex items-center justify-center space-x-2">
                                <i class="fa-solid fa-pen-to-square"></i>
                                <span>Input / Edit Nilai</span>
                            </a>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full py-12 text-center glass-card rounded-3xl">
                        <i class="fa-solid fa-triangle-exclamation text-3xl text-amber-500 mb-3"></i>
                        <p class="text-slate-500 text-sm italic">Anda belum memiliki penugasan mengajar mata pelajaran di kelas manapun.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>