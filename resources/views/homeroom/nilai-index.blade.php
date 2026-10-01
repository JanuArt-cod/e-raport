<x-app-layout>
    <div class="py-8 space-y-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Header Halaman -->
            <div class="glass-card p-6 md:p-8 rounded-3xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4 shadow-xl">
                <div>
                    <span class="text-xs px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-semibold border border-emerald-500/20">
                        Pusat Input Nilai Akademik
                    </span>
                    <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white mt-2">
                        Mata Pelajaran yang Diampu
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        Pilih kelas dan mata pelajaran di bawah ini untuk mulai mengisi atau memperbarui nilai peserta didik.
                    </p>
                </div>
                <div>
                    <a href="{{ route('homeroom.dashboard') }}" class="px-4 py-2.5 rounded-xl bg-slate-500/10 hover:bg-slate-500/20 text-slate-700 dark:text-slate-300 text-xs font-semibold transition-all inline-flex items-center space-x-2">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Kembali ke Dashboard</span>
                    </a>
                </div>
            </div>

            <!-- Daftar Kartu Mata Pelajaran -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($teachingAssignments as $assignment)
                    <div class="glass-card p-6 rounded-3xl shadow-xl space-y-5 flex flex-col justify-between border border-slate-200/60 dark:border-slate-800/60 hover:border-emerald-500/40 transition-all">
                        
                        <div class="space-y-3">
                            <div class="flex justify-between items-start">
                                <span class="text-xs px-3 py-1 rounded-full bg-slate-500/10 text-slate-700 dark:text-slate-300 font-bold border border-slate-500/20">
                                    {{ $assignment->schoolClass->name }}
                                </span>
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

                        <!-- Progres Bar Nilai -->
                        <div class="space-y-1.5 pt-3 border-t border-slate-200/60 dark:border-slate-800/60">
                            <div class="flex justify-between text-[11px] font-mono text-slate-600 dark:text-slate-400">
                                <span>Progres: {{ $assignment->graded_count }} dari {{ $assignment->total_students }} Siswa</span>
                                <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $assignment->percentage }}%</span>
                            </div>
                            <div class="w-full bg-slate-200 dark:bg-slate-700/60 rounded-full h-2.5 overflow-hidden border border-slate-300/40 dark:border-slate-700">
                                <div class="bg-emerald-500 h-full rounded-full transition-all duration-500 shadow-sm" style="width: {{ $assignment->percentage }}%;"></div>
                            </div>
                        </div>

                        <!-- Tombol Aksi Input Nilai -->
                        <div class="pt-2">
                            <a href="{{ route('homeroom.nilai.input', [$assignment->class_id, $assignment->subject_id]) }}" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold shadow-lg shadow-emerald-600/20 transition-all flex items-center justify-center space-x-2">
                                <i class="fa-solid fa-pen-to-square"></i>
                                <span>Input / Edit Nilai Mapel</span>
                            </a>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full py-12 text-center glass-card rounded-3xl">
                        <i class="fa-solid fa-triangle-exclamation text-3xl text-amber-500 mb-3"></i>
                        <p class="text-slate-500 text-sm italic">Anda tidak memiliki penugasan mata pelajaran tambahan.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>