<x-app-layout>
    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card p-8 rounded-3xl">
                
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-200/60 dark:border-slate-800/60">
                    <h1 class="text-lg font-bold text-slate-900 dark:text-white flex items-center">
                        <i class="fa-solid fa-pen-to-square text-amber-500 mr-2.5"></i> Edit Akun Pengguna
                    </h1>
                    <a href="{{ route('admin.users.index') }}" class="text-xs text-slate-500 hover:text-emerald-500 transition-colors">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 rounded-xl glass-input text-xs">
                        @error('name') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">Email / Username Login</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2.5 rounded-xl glass-input text-xs">
                        @error('email') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}></span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">Kata Sandi Baru <span class="text-[10px] text-slate-400 font-normal lowercase">(kosongkan jika tidak ingin mengubah password)</span></label>
                        <input type="password" name="password" class="w-full px-4 py-2.5 rounded-xl glass-input text-xs" placeholder="Biarkan kosong jika tetap">
                        @error('password') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-1.5">Hak Akses (Role)</label>
                        <div class="relative">
                            <select name="role" required class="w-full px-4 py-2.5 rounded-xl glass-input text-xs appearance-none bg-white/60 dark:bg-slate-900/70 text-slate-800 dark:text-slate-200 cursor-pointer focus:ring-2 focus:ring-emerald-500/50">
                                <option value="guru" {{ old('role', $user->role ?? '') == 'guru' ? 'selected' : '' }} class="bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200">Guru Mata Pelajaran</option>
                                <option value="wali_kelas" {{ old('role', $user->role ?? '') == 'wali_kelas' ? 'selected' : '' }} class="bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200">Wali Kelas</option>
                                <option value="panitia" {{ old('role', $user->role ?? '') == 'panitia' ? 'selected' : '' }} class="bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200">Panitia Ujian</option>
                                <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }} class="bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-200">Administrator</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-emerald-600 dark:text-emerald-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                        @error('role') <span class="text-rose-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-4 flex justify-end space-x-3">
                        <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-500/10 text-slate-600 dark:text-slate-400 text-xs font-semibold hover:bg-slate-500/20 transition-all">Batal</a>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-amber-600 to-yellow-500 hover:from-amber-500 hover:to-yellow-400 text-white text-xs font-semibold shadow-md shadow-amber-600/20 transition-all">Perbarui Akun</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>