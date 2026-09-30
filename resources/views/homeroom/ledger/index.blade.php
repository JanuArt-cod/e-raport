<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Header Halaman Ledger -->
            <div class="glass-card p-6 md:p-8 rounded-3xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4 shadow-xl">
                <div>
                    <span class="text-xs px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-semibold border border-emerald-500/20">
                        Rekapitulasi Akademik
                    </span>
                    <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white mt-2">
                        Ledger Nilai Kelas {{ $myClass->name }}
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        Tahun Ajaran: {{ \App\Models\Setting::get('academic_year', '2025/2026') }} | Total Siswa: {{ $students->count() }} Orang
                    </p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('homeroom.ledger.print') }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-slate-500/10 hover:bg-slate-500/20 text-slate-700 dark:text-slate-300 text-xs font-semibold transition-all inline-flex items-center space-x-2">
                        <i class="fa-solid fa-print"></i>
                        <span>Cetak Ledger</span>
                    </a>
                    <a href="{{ route('homeroom.dashboard') }}" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold shadow-lg shadow-emerald-600/20 transition-all inline-flex items-center space-x-2">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>

            <!-- Tabel Matriks Ledger Nilai -->
            <div class="glass-card rounded-3xl overflow-hidden shadow-xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-slate-500/5 text-[11px] uppercase tracking-wider text-slate-600 dark:text-slate-400 border-b border-slate-200/60 dark:border-slate-800/60">
                                <th class="py-3.5 px-4 text-center w-12 sticky left-0 bg-white dark:bg-slate-900 z-10">No</th>
                                <th class="py-3.5 px-4 sticky left-12 bg-white dark:bg-slate-900 z-10 min-w-[200px]">Nama Peserta Didik</th>
                                
                                <!-- Kolom Dinamis Berdasarkan Mata Pelajaran -->
                                @foreach($subjects as $subject)
                                    <th class="py-3.5 px-3 text-center border-l border-slate-200/40 dark:border-slate-800/40" title="{{ $subject->name }}">
                                        {{ Str::limit($subject->name, 12) }}
                                    </th>
                                @endforeach

                                <th class="py-3.5 px-4 text-center border-l border-slate-200/40 dark:border-slate-800/40">Total</th>
                                <th class="py-3.5 px-4 text-center">Rata-rata</th>
                                <th class="py-3.5 px-4 text-center">Peringkat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200/60 dark:divide-slate-800/60 text-xs">
                            @forelse($students as $index => $student)
                                <tr class="hover:bg-slate-500/5 transition-colors">
                                    <td class="py-3 px-4 text-center font-semibold text-slate-500 sticky left-0 bg-white dark:bg-slate-900">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4 font-bold text-slate-800 dark:text-slate-200 uppercase sticky left-12 bg-white dark:bg-slate-900">
                                        {{ $student->name }}
                                        <span class="block text-[10px] text-slate-400 font-mono font-normal">NISN: {{ $student->nisn }}</span>
                                    </td>

                                    <!-- Baris Nilai Per Mata Pelajaran -->
                                    @foreach($subjects as $subject)
                                        <td class="py-3 px-3 text-center border-l border-slate-200/40 dark:border-slate-800/40 font-mono text-slate-700 dark:text-slate-300">
                                            {{ $student->studentGrades[$subject->id] ?? 0 }}
                                        </td>
                                    @endforeach

                                    <!-- Total, Rata-rata, dan Peringkat -->
                                    <td class="py-3 px-4 text-center border-l border-slate-200/40 dark:border-slate-800/40 font-mono font-semibold text-slate-800 dark:text-slate-200">
                                        {{ $student->totalScore }}
                                    </td>
                                    <td class="py-3 px-4 text-center font-mono font-bold text-emerald-600 dark:text-emerald-400">
                                        {{ $student->average }}
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="px-2.5 py-1 rounded-full bg-slate-500/10 text-slate-700 dark:text-slate-300 font-bold text-[10px] border border-slate-500/20">
                                            #{{ $index + 1 }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ 5 + $subjects->count() }}" class="py-8 text-center text-slate-500 italic">Belum ada data siswa atau nilai di kelas ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>