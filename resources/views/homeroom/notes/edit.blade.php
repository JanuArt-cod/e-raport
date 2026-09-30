<x-app-layout>
    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Header Halaman Form -->
            <div class="glass-card p-6 md:p-8 rounded-3xl flex justify-between items-center shadow-xl">
                <div>
                    <span class="text-xs px-3 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 font-semibold border border-amber-500/20">
                        Formulir Catatan Siswa
                    </span>
                    <h1 class="text-xl md:text-2xl font-extrabold text-slate-900 dark:text-white mt-2 uppercase">
                        {{ $student->name }}
                    </h1>
                    <p class="text-xs text-slate-500 font-mono mt-0.5">NISN: {{ $student->nisn }}</p>
                </div>
                <a href="{{ route('homeroom.notes.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-500/15 hover:bg-slate-500/20 text-slate-700 dark:text-slate-300 text-xs font-semibold transition-all inline-flex items-center space-x-2">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>

            <!-- Form Input Catatan -->
            <div class="glass-card p-6 md:p-8 rounded-3xl shadow-xl">
                <form action="{{ route('homeroom.notes.update', $student->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 dark:text-slate-300 mb-2">
                            Catatan Perkembangan / Evaluasi Belajar:
                        </label>
                        <textarea name="note" rows="6" placeholder="Tuliskan catatan motivasi, pencapaian, atau saran pengembangan karakter peserta didik di sini..." 
                                  class="w-full text-xs rounded-2xl border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 p-4 leading-relaxed shadow-sm">{{ old('note', $studentNote->note ?? '') }}</textarea>
                        <p class="text-[11px] text-slate-400 mt-2">Catatan ini akan langsung termuat secara otomatis di lembar cetak rapor resmi peserta didik.</p>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4 border-t border-slate-200/60 dark:border-slate-800/60">
                        <a href="{{ route('homeroom.notes.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-500/10 text-slate-600 dark:text-slate-300 text-xs font-semibold hover:bg-slate-500/20 transition-all">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold shadow-lg shadow-emerald-600/20 transition-all flex items-center space-x-2">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>