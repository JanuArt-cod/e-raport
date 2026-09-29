<x-app-layout>
    <div x-data="{ deleteModal: false, deleteUrl: '' }" class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="glass-card p-6 rounded-3xl flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-xl font-bold text-slate-900 dark:text-white flex items-center">
                        <i class="fa-solid fa-network-wired text-cyan-600 dark:text-cyan-400 mr-2.5"></i> Mapping Penugasan Mengajar
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Atur penugasan guru pengampu mata pelajaran di setiap rombel kelas.</p>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2.5 rounded-xl bg-slate-500/10 hover:bg-slate-500/20 text-slate-700 dark:text-slate-300 text-xs font-semibold transition-all flex items-center space-x-2">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                    <a href="{{ route('admin.assignments.create') }}" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white text-xs font-semibold shadow-md shadow-emerald-600/20 transition-all flex items-center space-x-2">
                        <i class="fa-solid fa-plus"></i>
                        <span>Tambah Mapping</span>
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                     class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-xs font-medium flex items-center justify-between shadow-lg backdrop-blur-md transition-all">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-7 h-7 rounded-xl bg-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400"><i class="fa-solid fa-circle-check text-sm"></i></div>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-emerald-500 hover:text-emerald-400 p-1 cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif

            <div class="glass-card rounded-3xl overflow-hidden shadow-xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200/60 dark:border-slate-800/60 text-[11px] font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 bg-white/40 dark:bg-slate-900/40">
                                <th class="py-4 px-6">No</th>
                                <th class="py-4 px-6">Nama Guru Pengampu</th>
                                <th class="py-4 px-6">Mata Pelajaran</th>
                                <th class="py-4 px-6">Rombel Kelas</th>
                                <th class="py-4 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200/40 dark:divide-slate-800/40 text-xs text-slate-700 dark:text-slate-300">
                            @forelse($assignments as $index => $item)
                                <tr class="hover:bg-emerald-500/[0.03] transition-colors">
                                    <td class="py-4 px-6 font-medium">{{ $assignments->firstItem() + $index }}</td>
                                    <td class="py-4 px-6 font-bold text-slate-900 dark:text-white">{{ $item->teacher->name ?? '-' }}</td>
                                    <td class="py-4 px-6 text-emerald-600 dark:text-emerald-400 font-semibold">{{ $item->subject->name ?? '-' }} ({{ $item->subject->code ?? '' }})</td>
                                    <td class="py-4 px-6">
                                        <span class="px-2.5 py-1 rounded-full bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 border border-cyan-500/20 font-semibold text-[11px]">
                                            Kelas {{ $item->schoolClass->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <button @click="deleteModal = true; deleteUrl = '{{ route('admin.assignments.destroy', $item->id) }}'" type="button" class="w-8 h-8 rounded-xl bg-rose-500/10 text-rose-600 dark:text-rose-400 hover:bg-rose-500/20 flex items-center justify-center transition-all cursor-pointer mx-auto" title="Hapus">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-slate-500 dark:text-slate-400">Belum ada mapping penugasan mengajar yang terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($assignments->hasPages())
                    <div class="p-4 border-t border-slate-200/60 dark:border-slate-800/60">{{ $assignments->links() }}</div>
                @endif
            </div>

            <!-- Modal Delete -->
            <div x-show="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 backdrop-blur-md px-4" style="display: none;" x-transition.opacity>
                <div @click.away="deleteModal = false" class="glass-card p-6 sm:p-8 rounded-3xl max-w-sm w-full shadow-2xl border border-rose-500/30 text-center space-y-5">
                    <div class="w-14 h-14 rounded-2xl bg-rose-500/15 text-rose-500 flex items-center justify-center mx-auto text-2xl glow-effect animate-bounce">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">Konfirmasi Hapus Mapping</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5">Penugasan mengajar ini akan dihapus dari sistem.</p>
                    </div>
                    <div class="flex items-center space-x-3 pt-2">
                        <button @click="deleteModal = false" type="button" class="w-1/2 py-3 rounded-xl bg-slate-500/10 text-slate-700 dark:text-slate-300 text-xs font-semibold cursor-pointer">Batal</button>
                        <form :action="deleteUrl" method="POST" class="w-1/2">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-rose-600 to-red-500 text-white text-xs font-semibold shadow-lg cursor-pointer">Ya, Hapus</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>