<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 text-xs font-semibold flex items-center space-x-2">
                    <i class="fa-solid fa-circle-check text-base"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Header Halaman -->
            <div class="glass-card p-6 md:p-8 rounded-3xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4 shadow-xl">
                <div>
                    <span class="text-xs px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-semibold border border-emerald-500/20">
                        Manajemen Catatan Siswa
                    </span>
                    <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white mt-2">
                        Catatan Perkembangan Peserta Didik
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        Kelas Binaan: <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $myClass ? $myClass->name : '-' }}</span>
                    </p>
                </div>
                <div>
                    <a href="{{ route('homeroom.dashboard') }}" class="px-4 py-2.5 rounded-xl bg-slate-500/10 hover:bg-slate-500/20 text-slate-700 dark:text-slate-300 text-xs font-semibold transition-all inline-flex items-center space-x-2">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Kembali ke Dashboard</span>
                    </a>
                </div>
            </div>

            <!-- Tabel Daftar Siswa -->
            @if(!$myClass)
                <div class="glass-card p-12 text-center rounded-3xl space-y-3">
                    <p class="text-xs text-slate-500">Anda belum ditugaskan ke kelas manapun.</p>
                </div>
            @else
                <div class="glass-card rounded-3xl overflow-hidden shadow-xl">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-500/5 text-[11px] uppercase tracking-wider text-slate-600 dark:text-slate-400 border-b border-slate-200/60 dark:border-slate-800/60">
                                    <th class="py-3 px-6 text-center w-16">No</th>
                                    <th class="py-3 px-6">Nama Peserta Didik / NISN</th>
                                    <th class="py-3 px-6">Catatan Wali Kelas</th>
                                    <th class="py-3 px-6 text-center w-40">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200/60 dark:divide-slate-800/60 text-xs">
                                @forelse($myClass->students as $index => $student)
                                    <tr class="hover:bg-slate-500/5 transition-colors align-top">
                                        <td class="py-4 px-6 text-center font-semibold text-slate-500">{{ $index + 1 }}</td>
                                        <td class="py-4 px-6">
                                            <p class="font-bold text-slate-800 dark:text-slate-200 uppercase">{{ $student->name }}</p>
                                            <p class="text-[11px] text-slate-500 font-mono mt-0.5">NISN: {{ $student->nisn }}</p>
                                        </td>
                                        <td class="py-4 px-6">
                                            <p class="italic text-slate-600 dark:text-slate-300 leading-relaxed bg-slate-500/5 p-3 rounded-xl border border-slate-200/40 dark:border-slate-800/40">
                                                {{ $student->studentNote->note ?? 'Belum ada catatan khusus.' }}
                                            </p>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <a href="{{ route('homeroom.notes.edit', $student->id) }}" 
                                               class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 text-amber-600 dark:text-amber-400 font-semibold transition-all shadow-sm">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                <span>{{ $student->studentNote && $student->studentNote->note ? 'Edit Catatan' : 'Tulis Catatan' }}</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-slate-500 italic">Belum ada data siswa di kelas ini.</td>
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