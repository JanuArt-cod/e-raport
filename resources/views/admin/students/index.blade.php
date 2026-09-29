<x-app-layout>
    <div x-data="{ deleteModal: false, deleteUrl: '', importModal: false }" class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Header Aksi & Judul -->
            <div class="glass-card p-6 rounded-3xl flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                    <h1 class="text-xl font-bold text-slate-900 dark:text-white flex items-center">
                        <i class="fa-solid fa-user-graduate text-emerald-600 dark:text-emerald-400 mr-2.5"></i> Manajemen Data Siswa
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Kelola data siswa, penempatan rombel kelas, serta impor data massal via Excel.</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2.5 rounded-xl bg-slate-500/10 hover:bg-slate-500/20 text-slate-700 dark:text-slate-300 text-xs font-semibold transition-all flex items-center space-x-2">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                    <button @click="importModal = true" class="px-4 py-2.5 rounded-xl bg-teal-500/10 hover:bg-teal-500/20 border border-teal-500/30 text-teal-600 dark:text-teal-400 text-xs font-semibold transition-all flex items-center space-x-2 cursor-pointer">
                        <i class="fa-solid fa-file-excel"></i>
                        <span>Impor Excel</span>
                    </button>
                    <a href="{{ route('admin.students.create') }}" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white text-xs font-semibold shadow-md shadow-emerald-600/20 transition-all flex items-center space-x-2">
                        <i class="fa-solid fa-user-plus"></i>
                        <span>Tambah Siswa</span>
                    </a>
                </div>
            </div>

            <!-- Notifikasi Alert Bertema Glass Glow -->
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                     class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-xs font-medium flex items-center justify-between shadow-lg backdrop-blur-md transition-all">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-7 h-7 rounded-xl bg-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                            <i class="fa-solid fa-circle-check text-sm"></i>
                        </div>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-emerald-500 hover:text-emerald-400 p-1 cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif
            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                     class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-700 dark:text-rose-300 text-xs font-medium flex items-center justify-between shadow-lg backdrop-blur-md transition-all">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-7 h-7 rounded-xl bg-rose-500/20 flex items-center justify-center text-rose-600 dark:text-rose-400">
                            <i class="fa-solid fa-circle-exclamation text-sm"></i>
                        </div>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button @click="show = false" class="text-rose-500 hover:text-rose-400 p-1 cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif

            <!-- Filter & Search Bar -->
            <div class="glass-card p-4 rounded-2xl">
                <form method="GET" action="{{ route('admin.students.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama atau NISN..." class="w-full px-4 py-2.5 rounded-xl glass-input text-xs">
                    </div>
                    <div>
                        <select name="class_id" class="w-full px-4 py-2.5 rounded-xl glass-input text-xs appearance-none bg-white/60 dark:bg-slate-900/70 text-slate-800 dark:text-slate-200 cursor-pointer">
                            <option value="">-- Semua Kelas --</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }} class="bg-white dark:bg-slate-900">Kelas {{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button type="submit" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold shadow transition-all">
                            <i class="fa-solid fa-filter mr-1.5"></i> Filter
                        </button>
                        @if(request('search') || request('class_id'))
                            <a href="{{ route('admin.students.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-500/10 hover:bg-slate-500/20 text-slate-700 dark:text-slate-300 text-xs font-semibold transition-all text-center">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Tabel Data Siswa -->
            <div class="glass-card rounded-3xl overflow-hidden shadow-xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200/60 dark:border-slate-800/60 text-[11px] font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400 bg-white/40 dark:bg-slate-900/40">
                                <th class="py-4 px-6">No</th>
                                <th class="py-4 px-6">NISN</th>
                                <th class="py-4 px-6">Nama Lengkap Siswa</th>
                                <th class="py-4 px-6">Kelas</th>
                                <th class="py-4 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200/40 dark:divide-slate-800/40 text-xs text-slate-700 dark:text-slate-300">
                        @forelse($students as $index => $student)
                            <tr class="hover:bg-emerald-500/[0.03] transition-colors">
                                <td class="py-4 px-6 font-medium">{{ $students->firstItem() + $index }}</td>
                                <td class="py-4 px-6 font-mono text-emerald-600 dark:text-emerald-400 font-semibold">{{ $student->nisn }}</td>
                                <td class="py-4 px-6 font-bold text-slate-900 dark:text-white">{{ $student->name }}</td>
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-1 rounded-full bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 border border-cyan-500/20 font-semibold text-[11px]">
                                        Kelas {{ $student->schoolClass->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.students.edit', $student->id) }}" class="w-8 h-8 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 hover:bg-amber-500/20 flex items-center justify-center transition-all" title="Edit Siswa">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        </a>
                                        <button @click="deleteModal = true; deleteUrl = '{{ route('admin.students.destroy', $student->id) }}'" type="button" class="w-8 h-8 rounded-xl bg-rose-500/10 text-rose-600 dark:text-rose-400 hover:bg-rose-500/20 flex items-center justify-center transition-all cursor-pointer" title="Hapus Siswa">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-500 dark:text-slate-400">Belum ada data siswa yang terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    </table>
                </div>

                @if($students->hasPages())
                    <div class="p-4 border-t border-slate-200/60 dark:border-slate-800/60">
                        {{ $students->links() }}
                    </div>
                @endif
            </div>

            <!-- Modal Import Excel -->
            <div x-show="importModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 backdrop-blur-md px-4" style="display: none;" x-transition.opacity>
                <div @click.away="importModal = false" class="glass-card p-6 sm:p-8 rounded-3xl max-w-md w-full shadow-2xl border border-emerald-500/30 space-y-5">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-200/60 dark:border-slate-800/60">
                        <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center">
                            <i class="fa-solid fa-file-excel text-emerald-500 mr-2"></i> Impor Data Siswa
                        </h3>
                        <button @click="importModal = false" class="text-slate-400 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
                    </div>

                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                        Silakan unduh templat terlebih dahulu untuk memastikan format kolom (`nisn`, `name`, `nama_kelas`) sesuai dengan sistem.
                    </p>

                    <div class="text-center py-2">
                        <a href="{{ route('admin.students.template') }}" class="inline-flex items-center space-x-2 px-4 py-2 rounded-xl bg-slate-500/10 hover:bg-slate-500/20 text-emerald-600 dark:text-emerald-400 text-xs font-semibold transition-all">
                            <i class="fa-solid fa-download"></i>
                            <span>Unduh Templat Excel / CSV</span>
                        </a>
                    </div>

                    <form action="{{ route('admin.students.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Pilih File Excel / CSV</label>
                            <input type="file" name="file" accept=".xlsx, .xls, .csv" required class="w-full text-xs text-slate-500 dark:text-slate-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-500/10 file:text-emerald-600 dark:file:text-emerald-400 hover:file:bg-emerald-500/20 cursor-pointer">
                        </div>

                        <div class="flex items-center space-x-3 pt-2">
                            <button @click="importModal = false" type="button" class="w-1/2 py-3 rounded-xl bg-slate-500/10 text-slate-700 dark:text-slate-300 text-xs font-semibold hover:bg-slate-500/20 transition-all cursor-pointer">Batal</button>
                            <button type="submit" class="w-1/2 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 text-white text-xs font-semibold shadow-lg shadow-emerald-600/30 transition-all cursor-pointer">Unggah & Impor</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Custom Glass Delete Confirmation Modal -->
            <div x-show="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 backdrop-blur-md px-4" style="display: none;" x-transition.opacity>
                <div @click.away="deleteModal = false" class="glass-card p-6 sm:p-8 rounded-3xl max-w-sm w-full shadow-2xl border border-rose-500/30 text-center space-y-5">
                    <div class="w-14 h-14 rounded-2xl bg-rose-500/15 text-rose-500 flex items-center justify-center mx-auto text-2xl glow-effect animate-bounce">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">Konfirmasi Hapus Siswa</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5 leading-relaxed">Data siswa akan dihapus secara permanen dari sistem.</p>
                    </div>
                    <div class="flex items-center space-x-3 pt-2">
                        <button @click="deleteModal = false" type="button" class="w-1/2 py-3 rounded-xl bg-slate-500/10 text-slate-700 dark:text-slate-300 text-xs font-semibold hover:bg-slate-500/20 cursor-pointer">Batal</button>
                        <form :action="deleteUrl" method="POST" class="w-1/2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-rose-600 to-red-500 text-white text-xs font-semibold shadow-lg shadow-rose-600/30 cursor-pointer">Ya, Hapus</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>