<x-app-layout>
    <div class="py-8 print:py-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 print:max-w-none print:p-0">
            
            <!-- Tombol Navigasi & Cetak (Disembunyikan saat dicetak) -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 print:hidden">
                <div>
                    <span class="text-xs px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-semibold border border-emerald-500/20">
                        Arsip Akademik Guru
                    </span>
                    <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white mt-2">
                        Rekapitulasi Nilai: {{ $assignment->subject->name }}
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        Kelas: <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $assignment->schoolClass->name }}</span>
                    </p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('guru.dashboard') }}" class="px-4 py-2.5 rounded-xl bg-slate-500/10 hover:bg-slate-500/20 text-slate-700 dark:text-slate-300 text-xs font-semibold transition-all inline-flex items-center space-x-2">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                    <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold shadow-lg shadow-emerald-600/20 transition-all inline-flex items-center space-x-2">
                        <i class="fa-solid fa-print"></i>
                        <span>Cetak / Ekspor PDF</span>
                    </button>
                </div>
            </div>

            <!-- Kartu Statistik Singkat (Disembunyikan saat dicetak) -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 print:hidden">
                <div class="glass-card p-4 rounded-2xl shadow-md border border-slate-200/60 dark:border-slate-800/60">
                    <p class="text-[11px] text-slate-500 uppercase font-bold">Sudah Dinilai</p>
                    <p class="text-xl font-extrabold text-slate-800 dark:text-white mt-1">{{ $totalSudahDinilai }} / <span class="text-emerald-500">{{ $totalSiswa }}</span> Siswa</p>
                </div>
                <div class="glass-card p-4 rounded-2xl shadow-md border border-slate-200/60 dark:border-slate-800/60">
                    <p class="text-[11px] text-slate-500 uppercase font-bold">Rata-Rata Kelas</p>
                    <p class="text-xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-1">{{ $rataRata }}</p>
                </div>
                <div class="glass-card p-4 rounded-2xl shadow-md border border-slate-200/60 dark:border-slate-800/60">
                    <p class="text-[11px] text-slate-500 uppercase font-bold">Nilai Tertinggi</p>
                    <p class="text-xl font-extrabold text-blue-600 dark:text-blue-400 mt-1">{{ $nilaiTertinggi }}</p>
                </div>
                <div class="glass-card p-4 rounded-2xl shadow-md border border-slate-200/60 dark:border-slate-800/60">
                    <p class="text-[11px] text-slate-500 uppercase font-bold">Nilai Terendah</p>
                    <p class="text-xl font-extrabold text-amber-600 dark:text-amber-400 mt-1">{{ $nilaiTerendah }}</p>
                </div>
            </div>

            <!-- Lembar Dokumen Rekap (Tampil rapi di layar & mode cetak) -->
            <div class="glass-card p-8 rounded-3xl shadow-xl space-y-6 bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/60 print:shadow-none print:border-none print:p-0">
                
                <!-- Kop Dokumen Cetak -->
                <div class="text-center pb-6 border-b-2 border-slate-800 dark:border-slate-200 space-y-1">
                    <h2 class="text-lg font-extrabold uppercase text-slate-900 dark:text-white tracking-wider">Laporan Rekapitulasi Nilai Mata Pelajaran</h2>
                    <p class="text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase">MTSS Sirojul Athfal 1 • Tahun Ajaran 2026/2027</p>
                </div>

                <!-- Informasi Mata Pelajaran -->
                <div class="grid grid-cols-2 text-xs gap-4 text-slate-700 dark:text-slate-300 pb-2">
                    <div class="space-y-1">
                        <p><span class="font-bold">Mata Pelajaran:</span> {{ $assignment->subject->name }}</p>
                        <p><span class="font-bold">Guru Pengampu:</span> {{ auth()->user()->name }}</p>
                    </div>
                    <div class="space-y-1 text-right">
                        <p><span class="font-bold">Kelas:</span> {{ $assignment->schoolClass->name }}</p>
                        <p><span class="font-bold">Semester:</span> Ganjil</p>
                    </div>
                </div>

                <!-- Tabel Rekap Nilai -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse border border-slate-300 dark:border-slate-700 text-xs">
                        <thead>
                            <tr class="bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 uppercase text-[10px]">
                                <th class="border border-slate-300 dark:border-slate-700 py-2.5 px-3 text-center w-12">No</th>
                                <th class="border border-slate-300 dark:border-slate-700 py-2.5 px-3 w-32">NISN</th>
                                <th class="border border-slate-300 dark:border-slate-700 py-2.5 px-3">Nama Peserta Didik</th>
                                <th class="border border-slate-300 dark:border-slate-700 py-2.5 px-3 text-center w-28">Nilai Angka</th>
                                <th class="border border-slate-300 dark:border-slate-700 py-2.5 px-3 text-center w-40">Predikat Kompetensi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-300 dark:divide-slate-700">
                            @forelse($students as $index => $student)
                                @php
                                    $gradeRecord = $grades[$student->id] ?? null;
                                    $score = $gradeRecord->score ?? '-';
                                    $description = $gradeRecord->description ?? '-';
                                @endphp
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                    <td class="border border-slate-300 dark:border-slate-700 py-2.5 px-3 text-center font-semibold">{{ $index + 1 }}</td>
                                    <td class="border border-slate-300 dark:border-slate-700 py-2.5 px-3 font-mono">{{ $student->nisn }}</td>
                                    <td class="border border-slate-300 dark:border-slate-700 py-2.5 px-3 font-bold uppercase">{{ $student->name }}</td>
                                    <td class="border border-slate-300 dark:border-slate-700 py-2.5 px-3 text-center font-mono font-bold text-sm">{{ $score }}</td>
                                    <td class="border border-slate-300 dark:border-slate-700 py-2.5 px-3 text-center font-semibold text-emerald-600 dark:text-emerald-400">{{ $description }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="border border-slate-300 dark:border-slate-700 py-6 text-center italic text-slate-500">Belum ada data siswa di kelas ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Tanda Tangan Guru Pengampu -->
                <div class="pt-8 flex justify-end text-xs">
                    <div class="text-center space-y-16 w-64">
                        <p>Bogor, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                        <div>
                            <p class="font-bold uppercase underline">{{ auth()->user()->name }}</p>
                            <p class="text-slate-500 text-[11px] mt-0.5">Guru Mata Pelajaran</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Gaya Khusus Saat Dicetak (Print Media Styles) -->
    <style>
        @media print {
            body {
                background: white !important;
                color: black !important;
            }
            .glass-card {
                background: white !important;
                box-shadow: none !important;
                border: none !important;
            }
            nav, footer, header {
                display: none !important;
            }
        }
    </style>
</x-app-layout>