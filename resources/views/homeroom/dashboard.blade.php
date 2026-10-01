<x-app-layout>
    <div class="py-8 space-y-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Banner Sambutan Wali Kelas -->
            <div class="glass-card p-6 md:p-8 rounded-3xl shadow-xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <span class="text-xs px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-semibold border border-emerald-500/20">
                        Portal Wali Kelas & Guru Mapel
                    </span>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 dark:text-white mt-2">
                        Selamat Datang, {{ auth()->user()->name }}! 👩‍🏫
                    </h1>
                    <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-1">
                        Kelola data kelas binaan serta input nilai mata pelajaran yang Anda ampu dari satu tempat.
                    </p>
                </div>
            </div>

            <!-- BAGIAN 1: KELOLA KELAS BINAAN & DAFTAR SISWA -->
            <div class="space-y-4">
                <h2 class="text-lg font-extrabold text-slate-900 dark:text-white flex items-center space-x-2">
                    <i class="fa-solid fa-users-rectangle text-emerald-500"></i>
                    <span>Kelas Binaan & Daftar Siswa (Wali Kelas)</span>
                </h2>
                
                @if($homeroomClass)
                    <div class="glass-card p-6 rounded-3xl shadow-xl space-y-6 border border-slate-200/60 dark:border-slate-800/60">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div>
                                <span class="text-xs px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-bold">
                                    Kelas Aktif: {{ $homeroomClass->name }}
                                </span>
                                <h3 class="text-lg font-extrabold text-slate-900 dark:text-white mt-2">
                                    Rekapitulasi Peserta Didik Binaan
                                </h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                    Jumlah Total: <span class="font-bold text-slate-700 dark:text-slate-300">{{ $homeroomClass->students->count() }} Orang Siswa</span>
                                </p>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('homeroom.notes.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-500/10 hover:bg-slate-500/20 text-slate-700 dark:text-slate-300 text-xs font-semibold transition-all flex items-center space-x-2">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>Kelola Catatan Massal</span>
                                </a>
                                <a href="{{ route('homeroom.ledger.index') }}" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold shadow-lg shadow-emerald-600/20 transition-all flex items-center space-x-2">
                                    <i class="fa-solid fa-table-cells"></i>
                                    <span>Ledger Nilai</span>
                                </a>
                            </div>
                        </div>

                        <!-- Tabel Daftar Siswa Binaan -->
                        <div class="overflow-x-auto pt-2 border-t border-slate-200/60 dark:border-slate-800/60">
                            <table class="w-full text-left border-collapse text-xs">
                                <thead>
                                    <tr class="bg-slate-500/5 text-[11px] uppercase tracking-wider text-slate-600 dark:text-slate-400 border-b border-slate-200/60 dark:border-slate-800/60">
                                        <th class="py-3 px-4 text-center w-12">No</th>
                                        <th class="py-3 px-4 w-36">NISN</th>
                                        <th class="py-3 px-4">Nama Peserta Didik</th>
                                        <th class="py-3 px-4">Status Catatan Rapor</th>
                                        <th class="py-3 px-4 text-center w-32">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200/60 dark:divide-slate-800/60">
                                    @forelse($homeroomClass->students as $index => $student)
                                        <tr class="hover:bg-slate-500/5 transition-colors">
                                            <td class="py-3 px-4 text-center font-semibold text-slate-500">{{ $index + 1 }}</td>
                                            <td class="py-3 px-4 font-mono">{{ $student->nisn ?? '-' }}</td>
                                            <td class="py-3 px-4 font-bold uppercase text-slate-800 dark:text-slate-200">{{ $student->name }}</td>
                                            <td class="py-3 px-4">
                                                @if($student->studentNote && $student->studentNote->note)
                                                    <span class="text-[10px] px-2.5 py-1 rounded-full font-bold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">
                                                        Sudah Diisi
                                                    </span>
                                                @else
                                                    <span class="text-[10px] px-2.5 py-1 rounded-full font-bold bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20">
                                                        Belum Ada Catatan
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                <a href="{{ route('homeroom.notes.edit', $student->id) }}" class="px-3 py-1.5 rounded-xl bg-emerald-600/10 hover:bg-emerald-600/20 text-emerald-600 dark:text-emerald-400 font-semibold border border-emerald-500/20 transition-all inline-flex items-center space-x-1 text-[11px]">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                    <span>Catatan</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-6 text-center text-slate-500 italic">Belum ada data siswa terdaftar di kelas binaan ini.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="glass-card p-6 rounded-3xl text-center text-slate-500 text-xs italic">
                        Anda tidak terdaftar sebagai wali kelas di kelas manapun.
                    </div>
                @endif
            </div>

            {{-- <!-- BAGIAN 2: MATA PELAJARAN YANG DIAMPU (GURU MAPEL) -->
            <div class="space-y-4 pt-4">
                <h2 class="text-lg font-extrabold text-slate-900 dark:text-white flex items-center space-x-2">
                    <i class="fa-solid fa-book-open-reader text-emerald-500"></i>
                    <span>Mata Pelajaran yang Diampu (Guru Mapel)</span>
                </h2>

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
                        <div class="col-span-full py-8 text-center glass-card rounded-3xl text-slate-500 text-xs italic">
                            Anda tidak memiliki penugasan mata pelajaran tambahan selain wali kelas.
                        </div>
                    @endforelse
                </div>
            </div> --}}

        </div>
    </div>
</x-app-layout>