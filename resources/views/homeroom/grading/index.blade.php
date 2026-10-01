<x-app-layout>
    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Header Halaman -->
            <div class="glass-card p-6 sm:p-8 rounded-3xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4 shadow-xl">
                <div>
                    <span class="text-[10px] sm:text-xs px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-semibold border border-emerald-500/20">
                        Monitoring Akademik
                    </span>
                    <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white mt-2">
                        Status Pengisian Nilai Guru Mapel
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        Kelas Binaan: <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $myClass->name }}</span> | Total Siswa: {{ $myClass->students->count() }} Orang
                    </p>
                </div>
                <div class="w-full md:w-auto">
                    <a href="{{ route('homeroom.dashboard') }}" class="w-full md:w-auto px-4 py-2.5 rounded-xl bg-slate-500/10 hover:bg-slate-500/20 text-slate-700 dark:text-slate-300 text-xs font-semibold transition-all inline-flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Kembali ke Dashboard</span>
                    </a>
                </div>
            </div>

            <!-- Tabel Daftar Status Mapel -->
            <div class="glass-card rounded-3xl overflow-hidden shadow-xl border border-slate-200/60 dark:border-slate-800/60">
                <div class="p-5 sm:p-6 border-b border-slate-200/60 dark:border-slate-800/60">
                    <h3 class="font-bold text-sm text-slate-800 dark:text-slate-100 flex items-center space-x-2">
                        <i class="fa-solid fa-clipboard-list text-emerald-500"></i>
                        <span>Rekapitulasi Detail Kelengkapan Nilai Per Mata Pelajaran</span>
                    </h3>
                </div>

                <div class="overflow-x-auto w-full">
                    <table class="w-full text-left border-collapse min-w-[600px]">
                        <thead>
                            <tr class="bg-slate-500/5 text-[11px] uppercase tracking-wider text-slate-600 dark:text-slate-400 border-b border-slate-200/60 dark:border-slate-800/60">
                                <th class="py-3 px-4 sm:px-6 text-center w-16">No</th>
                                <th class="py-3 px-4 sm:px-6">Mata Pelajaran</th>
                                <th class="py-3 px-4 sm:px-6 text-center">Progres Input Nilai</th>
                                <th class="py-3 px-4 sm:px-6 text-center">Status Pengisian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200/60 dark:divide-slate-800/60 text-xs">
                            @forelse($monitoringData as $index => $data)
                                <tr class="hover:bg-slate-500/5 transition-colors">
                                    <td class="py-4 px-4 sm:px-6 text-center font-semibold text-slate-500">{{ $index + 1 }}</td>
                                    <td class="py-4 px-4 sm:px-6 font-bold text-slate-800 dark:text-slate-200 uppercase">
                                        {{ $data['subject']->name }}
                                    </td>
                                    <td class="py-4 px-4 sm:px-6">
                                        <div class="w-full max-w-xs mx-auto space-y-1.5">
                                            <!-- Teks Keterangan & Persentase -->
                                            <div class="flex justify-between text-[11px] font-mono text-slate-600 dark:text-slate-300">
                                                <span>{{ $data['graded_count'] }} dari {{ $data['total_students'] }} Siswa</span>
                                                <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $data['percentage'] }}%</span>
                                            </div>
                                            
                                            <!-- Batang Progress Bar Visual -->
                                            <div class="w-full bg-slate-200 dark:bg-slate-700/60 rounded-full h-2.5 overflow-hidden border border-slate-300/40 dark:border-slate-700">
                                                <div class="bg-emerald-500 h-full rounded-full transition-all duration-500 shadow-sm" style="width: {{ $data['percentage'] }}%;"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 sm:px-6 text-center whitespace-nowrap">
                                        @if($data['status'] === 'Selesai')
                                            <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-semibold text-[10px] border border-emerald-500/20 inline-flex items-center space-x-1">
                                                <i class="fa-solid fa-check"></i>
                                                <span>Selesai Lengkap</span>
                                            </span>
                                        @elseif($data['status'] === 'Sebagian')
                                            <span class="px-3 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 font-semibold text-[10px] border border-amber-500/20 inline-flex items-center space-x-1">
                                                <i class="fa-solid fa-clock"></i>
                                                <span>Belum Selesai (Sebagian)</span>
                                            </span>
                                        @else
                                            <span class="px-3 py-1 rounded-full bg-rose-500/10 text-rose-600 dark:text-rose-400 font-semibold text-[10px] border border-rose-500/20 inline-flex items-center space-x-1">
                                                <i class="fa-solid fa-triangle-exclamation"></i>
                                                <span>Belum Menginput</span>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-slate-500 italic">Belum ada mata pelajaran terdaftar di sistem.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>