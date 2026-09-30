<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="glass-card p-6 rounded-3xl flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <span class="text-xs px-3 py-1 rounded-full bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 font-semibold border border-cyan-500/20">
                        Matriks Rekapitulasi Nilai
                    </span>
                    <h1 class="text-xl font-bold text-slate-900 dark:text-white mt-2">
                        Kelas {{ $schoolClass->name }}
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Daftar nilai seluruh mata pelajaran untuk setiap siswa di kelas ini.</p>
                </div>
                <a href="{{ route('admin.reports.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-500/10 hover:bg-slate-500/20 text-slate-700 dark:text-slate-300 text-xs font-semibold transition-all flex items-center space-x-2">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>

            <div class="glass-card rounded-3xl overflow-hidden shadow-xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="border-b border-slate-200/60 dark:border-slate-800/60 text-[11px] font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 bg-white/40 dark:bg-slate-900/40">
                                <th class="py-4 px-4 text-center">No</th>
                                <th class="py-4 px-4">NISN</th>
                                <th class="py-4 px-6">Nama Siswa</th>
                                @foreach($subjects as $subj)
                                    <th class="py-4 px-4 text-center" title="{{ $subj->name }}">{{ $subj->code }}</th>
                                @endforeach
                                <th class="py-4 px-4 text-center">Aksi Rapor</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200/40 dark:divide-slate-800/40 text-xs text-slate-700 dark:text-slate-300">
                            @forelse($students as $index => $student)
                                <tr class="hover:bg-emerald-500/[0.03] transition-colors">
                                    <td class="py-4 px-4 text-center font-medium">{{ $index + 1 }}</td>
                                    <td class="py-4 px-4 font-mono text-emerald-600 dark:text-emerald-400 font-semibold">{{ $student->nisn }}</td>
                                    <td class="py-4 px-6 font-bold text-slate-900 dark:text-white">{{ $student->name }}</td>
                                    
                                    @foreach($subjects as $subj)
                                        @php
                                            $score = $gradeMap[$student->id][$subj->id] ?? null;
                                        @endphp
                                        <td class="py-4 px-4 text-center font-mono font-semibold {{ $score !== null ? 'text-slate-800 dark:text-slate-200' : 'text-slate-400' }}">
                                            {{ $score !== null ? $score : '-' }}
                                        </td>
                                    @endforeach

                                    <td class="py-4 px-4 text-center">
                                        <a href="{{ route('admin.reports.print-student', $student->id) }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 hover:bg-cyan-500/20 font-semibold transition-all inline-flex items-center space-x-1" title="Cetak Rapor Siswa">
                                            <i class="fa-solid fa-print text-[11px]"></i>
                                            <span>Cetak</span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ 4 + $subjects->count() }}" class="py-8 text-center text-slate-500">Belum ada data siswa di kelas ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>