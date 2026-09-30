<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Banner Sambutan Wali Kelas -->
            <div class="glass-card p-6 md:p-8 rounded-3xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4 shadow-xl">
                <div>
                    <span class="text-xs px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-semibold border border-emerald-500/20">
                        Portal Wali Kelas
                    </span>
                    <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white mt-2">
                        Selamat Datang, {{ auth()->user()->name }}!
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        Anda bertindak sebagai Wali Kelas untuk Rombongan Belajar: 
                        <span class="font-bold text-emerald-600 dark:text-emerald-400 text-sm">
                            {{ $myClass ? $myClass->name : 'Belum Ditugaskan ke Kelas Manapun' }}
                        </span>
                    </p>
                </div>

                @if($myClass)
                    <div class="flex items-center space-x-3 bg-emerald-500/10 px-4 py-3 rounded-2xl border border-emerald-500/20">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400 font-bold">
                            <i class="fa-solid fa-users text-lg"></i>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-500 uppercase tracking-wider block font-semibold">Total Siswa Binaan</span>
                            <span class="text-base font-bold text-slate-800 dark:text-slate-200">{{ $myClass->students->count() }} Siswa</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Konten Utama: Daftar Siswa di Kelas Binaan -->
            @if(!$myClass)
                <!-- Peringatan Jika Belum Ditugaskan ke Kelas -->
                <div class="glass-card p-12 text-center rounded-3xl space-y-3">
                    <div class="w-16 h-16 rounded-full bg-amber-500/10 text-amber-500 flex items-center justify-center mx-auto text-2xl">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-800 dark:text-slate-200">Belum Ada Kelas yang Ditugaskan</h3>
                    <p class="text-xs text-slate-500 max-w-md mx-auto">Akun Anda belum dihubungkan sebagai wali kelas pada menu pengaturan kelas oleh Admin. Silakan hubungi Administrator sistem.</p>
                </div>
            @else
                {{-- <div class="flex items-center space-x-3">
                    <!-- Tombol Menuju CRUD Catatan -->
                    <a href="{{ route('homeroom.notes.index') }}" class="px-4 py-3 rounded-2xl bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/20 text-amber-600 dark:text-amber-400 font-semibold text-xs transition-all inline-flex items-center space-x-2">
                        <i class="fa-solid fa-pen-to-square text-base"></i>
                        <span>Catatan Wali Kelas</span>
                    </a>
                </div> --}}
                <!-- Tabel Daftar Siswa Binaan -->
                <div class="glass-card rounded-3xl overflow-hidden shadow-xl">
                    <div class="p-6 border-b border-slate-200/60 dark:border-slate-800/60 flex justify-between items-center">
                        <h3 class="font-bold text-sm md:text-base text-slate-800 dark:text-slate-100 flex items-center space-x-2">
                            <i class="fa-solid fa-list-check text-emerald-500"></i>
                            <span>Daftar Siswa Kelas {{ $myClass->name }}</span>
                        </h3>
                        <span class="text-xs text-slate-500">Tahun Ajaran: {{ \App\Models\Setting::get('academic_year', '2025/2026') }}</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-500/5 text-[11px] uppercase tracking-wider text-slate-600 dark:text-slate-400 border-b border-slate-200/60 dark:border-slate-800/60">
                                    <th class="py-3 px-6 text-center w-16">No</th>
                                    <th class="py-3 px-6">Nama Peserta Didik</th>
                                    <th class="py-3 px-6">NISN</th>
                                    <th class="py-3 px-6 text-center">Status Catatan</th>
                                    <th class="py-3 px-6 text-center">Aksi / Rapor</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200/60 dark:divide-slate-800/60 text-xs">
                                @forelse($myClass->students as $index => $student)
                                    <tr class="hover:bg-slate-500/5 transition-colors">
                                        <td class="py-4 px-6 text-center font-semibold text-slate-500">{{ $index + 1 }}</td>
                                        <td class="py-4 px-6 font-bold text-slate-800 dark:text-slate-200 uppercase">{{ $student->name }}</td>
                                        <td class="py-4 px-6 text-slate-600 dark:text-slate-400 font-mono">{{ $student->nisn }}</td>
                                        <td class="py-4 px-6 text-center">
                                            @if($student->studentNote && $student->studentNote->note)
                                                <span class="px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-semibold text-[10px] border border-emerald-500/20">
                                                    Sudah Ada Catatan
                                                </span>
                                            @else
                                                <span class="px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 font-semibold text-[10px] border border-amber-500/20">
                                                    Belum Ada Catatan
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-center space-x-2">
                                            <!-- Tombol Pratinjau / Cetak Rapor Siswa -->
                                            <a href="{{ route('admin.reports.print', $student->id) }}" target="_blank" 
                                               class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-xl bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 font-semibold transition-all" title="Cetak Rapor Siswa">
                                                <i class="fa-solid fa-print"></i>
                                                <span>Cetak</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-slate-500 italic">Belum ada data siswa terdaftar di kelas ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            @endif

        </div>
    </div>
</x-app-layout>