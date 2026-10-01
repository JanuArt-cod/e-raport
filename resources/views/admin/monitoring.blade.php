<x-app-layout>
    <div class="py-8" x-data="{ activeTab: 'grades' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Header Halaman -->
            <div class="glass-card p-6 md:p-8 rounded-3xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4 shadow-xl">
                <div>
                    <span class="text-xs px-3 py-1 rounded-full bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-semibold border border-indigo-500/20">
                        Pusat Kendali Administrator
                    </span>
                    <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white mt-2">
                        Monitoring Pengisian Rapor
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        Pantau progres kelengkapan input nilai guru mata pelajaran dan catatan perkembangan peserta didik oleh wali kelas.
                    </p>
                </div>

                <!-- Tombol Tab Navigasi -->
                <div class="flex items-center space-x-2 bg-slate-200/60 dark:bg-slate-800/60 p-1.5 rounded-2xl border border-slate-300/40 dark:border-slate-700/60">
                    <button @click="activeTab = 'grades'" 
                            :class="activeTab === 'grades' ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'"
                            class="px-4 py-2 rounded-xl text-xs font-semibold transition-all flex items-center space-x-2">
                        <i class="fa-solid fa-book-open"></i>
                        <span>Nilai Guru Mapel</span>
                    </button>
                    <button @click="activeTab = 'notes'" 
                            :class="activeTab === 'notes' ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'"
                            class="px-4 py-2 rounded-xl text-xs font-semibold transition-all flex items-center space-x-2">
                        <i class="fa-solid fa-pen-nib"></i>
                        <span>Catatan Wali Kelas</span>
                    </button>
                </div>
            </div>

            <!-- TAB 1: MONITORING NILAI GURU MAPEL -->
            <div x-show="activeTab === 'grades'" class="space-y-6">
                <div class="glass-card rounded-3xl overflow-hidden shadow-xl">
                    <div class="p-6 border-b border-slate-200/60 dark:border-slate-800/60 flex justify-between items-center">
                        <h3 class="font-bold text-sm text-slate-800 dark:text-slate-100 flex items-center space-x-2">
                            <i class="fa-solid fa-chart-pie text-indigo-500"></i>
                            <span>Status Kelengkapan Input Nilai per Mata Pelajaran</span>
                        </h3>
                        <span class="text-xs font-mono text-slate-500">Total Penugasan: {{ $assignments->count() }}</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-500/5 text-[11px] uppercase tracking-wider text-slate-600 dark:text-slate-400 border-b border-slate-200/60 dark:border-slate-800/60">
                                    <th class="py-3.5 px-4 text-center w-12">No</th>
                                    <th class="py-3.5 px-4">Guru Pengampu</th>
                                    <th class="py-3.5 px-4">Kelas & Mata Pelajaran</th>
                                    <th class="py-3.5 px-4 text-center">Progres Input</th>
                                    <th class="py-3.5 px-4 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200/60 dark:divide-slate-800/60 text-xs">
                                @forelse($assignments as $index => $item)
                                    <tr class="hover:bg-slate-500/5 transition-colors">
                                        <td class="py-4 px-4 text-center font-semibold text-slate-500">{{ $index + 1 }}</td>
                                        <td class="py-4 px-4">
                                            <p class="font-bold text-slate-800 dark:text-slate-200 uppercase">{{ $item->teacher->name ?? 'Belum Ditugaskan' }}</p>
                                            <p class="text-[11px] text-slate-500 font-mono mt-0.5">{{ $item->teacher->email ?? '-' }}</p>
                                        </td>
                                        <td class="py-4 px-4">
                                            <p class="font-extrabold text-indigo-600 dark:text-indigo-400">{{ $item->schoolClass->name ?? '-' }}</p>
                                            <p class="text-[11px] text-slate-600 dark:text-slate-300 uppercase font-semibold mt-0.5">{{ $item->subject->name ?? '-' }}</p>
                                        </td>
                                        <td class="py-4 px-4 w-64">
                                            <div class="space-y-1">
                                                <div class="flex justify-between text-[11px] font-mono text-slate-600 dark:text-slate-400">
                                                    <span>{{ $item->graded_count }} / {{ $item->total_students }} Siswa</span>
                                                    <span class="font-bold text-indigo-600 dark:text-indigo-400">{{ $item->percentage }}%</span>
                                                </div>
                                                <div class="w-full bg-slate-200 dark:bg-slate-700/60 rounded-full h-2 overflow-hidden border border-slate-300/40 dark:border-slate-700">
                                                    <div class="bg-indigo-500 h-full rounded-full transition-all duration-500" style="width: {{ $item->percentage }}%;"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <span class="text-[10px] px-3 py-1 rounded-full font-bold border {{ $item->status_class }}">
                                                {{ $item->status_label }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-slate-500 italic">Belum ada data penugasan mengajar guru.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- TAB 2: MONITORING CATATAN WALI KELAS -->
            <div x-show="activeTab === 'notes'" class="space-y-6" style="display: none;">
                <div class="glass-card rounded-3xl overflow-hidden shadow-xl">
                    <div class="p-6 border-b border-slate-200/60 dark:border-slate-800/60 flex justify-between items-center">
                        <h3 class="font-bold text-sm text-slate-800 dark:text-slate-100 flex items-center space-x-2">
                            <i class="fa-solid fa-clipboard-user text-indigo-500"></i>
                            <span>Status Kelengkapan Catatan Perkembangan oleh Wali Kelas</span>
                        </h3>
                        <span class="text-xs font-mono text-slate-500">Total Kelas: {{ $classes->count() }}</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-500/5 text-[11px] uppercase tracking-wider text-slate-600 dark:text-slate-400 border-b border-slate-200/60 dark:border-slate-800/60">
                                    <th class="py-3.5 px-4 text-center w-12">No</th>
                                    <th class="py-3.5 px-4">Kelas</th>
                                    <th class="py-3.5 px-4">Wali Kelas</th>
                                    <th class="py-3.5 px-4 text-center">Progres Catatan Siswa</th>
                                    <th class="py-3.5 px-4 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200/60 dark:divide-slate-800/60 text-xs">
                                @forelse($classes as $index => $class)
                                    <tr class="hover:bg-slate-500/5 transition-colors">
                                        <td class="py-4 px-4 text-center font-semibold text-slate-500">{{ $index + 1 }}</td>
                                        <td class="py-4 px-4 font-extrabold text-indigo-600 dark:text-indigo-400 text-sm">
                                            {{ $class->name }}
                                        </td>
                                        <td class="py-4 px-4">
                                            <p class="font-bold text-slate-800 dark:text-slate-200 uppercase">{{ $class->homeroomTeacher->name ?? 'Belum Ditugaskan' }}</p>
                                            <p class="text-[11px] text-slate-500 font-mono mt-0.5">{{ $class->homeroomTeacher->email ?? '-' }}</p>
                                        </td>
                                        <td class="py-4 px-4 w-64">
                                            <div class="space-y-1">
                                                <div class="flex justify-between text-[11px] font-mono text-slate-600 dark:text-slate-400">
                                                    <span>{{ $class->noted_count }} / {{ $class->total_students }} Siswa</span>
                                                    <span class="font-bold text-indigo-600 dark:text-indigo-400">{{ $class->note_percentage }}%</span>
                                                </div>
                                                <div class="w-full bg-slate-200 dark:bg-slate-700/60 rounded-full h-2 overflow-hidden border border-slate-300/40 dark:border-slate-700">
                                                    <div class="bg-indigo-500 h-full rounded-full transition-all duration-500" style="width: {{ $class->note_percentage }}%;"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <span class="text-[10px] px-3 py-1 rounded-full font-bold border {{ $class->note_status_class }}">
                                                {{ $class->note_status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-slate-500 italic">Belum ada data kelas yang terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>