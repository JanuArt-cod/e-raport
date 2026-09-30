<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="glass-card p-6 rounded-3xl flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <span class="text-xs px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-semibold border border-emerald-500/20">
                        Konfigurasi Global
                    </span>
                    <h1 class="text-xl font-bold text-slate-900 dark:text-white mt-2">
                        Setting Sistem & Logo Rapor Cetak
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Kelola logo instansi, identitas sekolah, alamat, serta data penandatanganan rapor siswa.</p>
                </div>
                <a href="{{ route('dashboard') }}" class="px-4 py-2.5 rounded-xl bg-slate-500/10 hover:bg-slate-500/20 text-slate-700 dark:text-slate-300 text-xs font-semibold transition-all flex items-center space-x-2">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>

            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                     class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-xs font-medium flex items-center justify-between shadow-lg backdrop-blur-md">
                    <div class="flex items-center space-x-2.5">
                        <div class="w-7 h-7 rounded-xl bg-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400"><i class="fa-solid fa-circle-check text-sm"></i></div>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-emerald-500 hover:text-emerald-400 p-1 cursor-pointer"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif

            <div class="glass-card p-8 rounded-3xl shadow-xl">
                <!-- Tambahkan enctype agar bisa upload file -->
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Unggah Logo Sekolah -->
                        <div class="space-y-3 md:col-span-2 p-4 rounded-2xl bg-slate-500/5 border border-slate-200/60 dark:border-slate-800/60 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center overflow-hidden shadow-sm flex-shrink-0">
                                    @if(isset($settings['school_logo']) && $settings['school_logo'])
                                        <img src="{{ asset($settings['school_logo']) }}" alt="Logo Sekolah" class="w-full h-full object-contain p-1">
                                    @else
                                        <i class="fa-solid fa-image text-slate-400 text-xl"></i>
                                    @endif
                                </div>
                                <div>
                                    <label class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 block">Logo Resmi Sekolah / Instansi</label>
                                    <span class="text-[11px] text-slate-500">Format: PNG, JPG, JPEG, SVG (Maks. 2MB)</span>
                                </div>
                            </div>
                            <input type="file" name="school_logo" accept="image/*"
                                   class="text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-500/10 file:text-emerald-600 hover:file:bg-emerald-500/20 cursor-pointer">
                            @error('school_logo') <span class="text-[10px] text-rose-500 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Instansi / Pemerintah -->
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Baris Atas Kop (Instansi / Pemerintah / Dinas)</label>
                            <input type="text" name="government_name" value="{{ old('government_name', $settings['government_name'] ?? '') }}" required
                                   class="w-full px-4 py-3 rounded-2xl bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-slate-100 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                            @error('government_name') <span class="text-[10px] text-rose-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- Nama Sekolah -->
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Nama Sekolah / Madrasah</label>
                            <input type="text" name="school_name" value="{{ old('school_name', $settings['school_name'] ?? '') }}" required
                                   class="w-full px-4 py-3 rounded-2xl bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-slate-100 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                            @error('school_name') <span class="text-[10px] text-rose-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- Kota Tanda Tangan -->
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Kota / Wilayah Tanda Tangan</label>
                            <input type="text" name="school_city" value="{{ old('school_city', $settings['school_city'] ?? '') }}" required
                                   class="w-full px-4 py-3 rounded-2xl bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-slate-100 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                            @error('school_city') <span class="text-[10px] text-rose-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- Alamat Sekolah -->
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Alamat Lengkap Sekolah (Baris Ketiga Kop)</label>
                            <input type="text" name="school_address" value="{{ old('school_address', $settings['school_address'] ?? '') }}" required
                                   class="w-full px-4 py-3 rounded-2xl bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-slate-100 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                            @error('school_address') <span class="text-[10px] text-rose-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- Tahun Ajaran -->
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Tahun Ajaran Aktif</label>
                            <input type="text" name="academic_year" value="{{ old('academic_year', $settings['academic_year'] ?? '') }}" required placeholder="Contoh: 2025/2026"
                                   class="w-full px-4 py-3 rounded-2xl bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-slate-100 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                            @error('academic_year') <span class="text-[10px] text-rose-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- Semester -->
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Semester Aktif</label>
                            <select name="semester" class="w-full px-4 py-3 rounded-2xl bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-slate-100 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                                <option value="Ganjil" {{ (isset($settings['semester']) && $settings['semester'] == 'Ganjil') ? 'selected' : '' }}>Ganjil</option>
                                <option value="Genap" {{ (isset($settings['semester']) && $settings['semester'] == 'Genap') ? 'selected' : '' }}>Genap</option>
                            </select>
                            @error('semester') <span class="text-[10px] text-rose-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- Nama Kepala Sekolah -->
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Nama Kepala Sekolah / Pimpinan</label>
                            <input type="text" name="headmaster_name" value="{{ old('headmaster_name', $settings['headmaster_name'] ?? '') }}" required
                                   class="w-full px-4 py-3 rounded-2xl bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-slate-100 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                            @error('headmaster_name') <span class="text-[10px] text-rose-500">{{ $message }}</span> @enderror
                        </div>

                        <!-- NIP Kepala Sekolah -->
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">NIP Kepala Sekolah</label>
                            <input type="text" name="headmaster_nip" value="{{ old('headmaster_nip', $settings['headmaster_nip'] ?? '') }}" required
                                   class="w-full px-4 py-3 rounded-2xl bg-white/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-slate-100 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                            @error('headmaster_nip') <span class="text-[10px] text-rose-500">{{ $message }}</span> @enderror
                        </div>

                    </div>

                    <div class="pt-6 border-t border-slate-200/60 dark:border-slate-800/60 flex justify-end">
                        <button type="submit" class="px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-500 hover:to-teal-400 text-white text-xs font-semibold shadow-lg shadow-emerald-600/20 transition-all flex items-center space-x-2 cursor-pointer">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>Simpan Perubahan Pengaturan</span>
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>