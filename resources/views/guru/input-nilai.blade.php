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
                        Portal Guru Mata Pelajaran
                    </span>
                    <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white mt-2">
                        Input Nilai & Kompetensi: {{ $assignment->subject->name }}
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        Kelas: <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $assignment->schoolClass->name }}</span> | Total Siswa: {{ $students->count() }} Orang
                    </p>
                </div>
                <div>
                    <a href="{{ route('guru.dashboard') }}" class="px-4 py-2.5 rounded-xl bg-slate-500/10 hover:bg-slate-500/20 text-slate-700 dark:text-slate-300 text-xs font-semibold transition-all inline-flex items-center space-x-2">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Kembali ke Dashboard</span>
                    </a>
                </div>
            </div>

            <!-- Ubah dari route('guru.grades.store') menjadi route('guru.nilai.store') -->
            <form action="{{ route('guru.nilai.store', [$classId, $subjectId]) }}" method="POST">
                @csrf

                <div class="glass-card rounded-3xl overflow-hidden shadow-xl space-y-4">
                    <div class="p-6 border-b border-slate-200/60 dark:border-slate-800/60 flex justify-between items-center">
                        <h3 class="font-bold text-sm text-slate-800 dark:text-slate-100 flex items-center space-x-2">
                            <i class="fa-solid fa-pen-to-square text-emerald-500"></i>
                            <span>Form Penilaian & Predikat Capaian Kompetensi</span>
                        </h3>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold shadow-lg shadow-emerald-600/20 transition-all flex items-center space-x-2">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>Simpan Seluruh Nilai</span>
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-500/5 text-[11px] uppercase tracking-wider text-slate-600 dark:text-slate-400 border-b border-slate-200/60 dark:border-slate-800/60">
                                    <th class="py-3.5 px-4 text-center w-12">No</th>
                                    <th class="py-3.5 px-4 w-1/3">Nama Peserta Didik / NISN</th>
                                    <!-- Kolom Nilai Dilebarkan (w-48) -->
                                    <th class="py-3.5 px-4 text-center w-48">Nilai (0-100)</th>
                                    <th class="py-3.5 px-4 text-center">Predikat Capaian Kompetensi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200/60 dark:divide-slate-800/60 text-xs">
                                @forelse($students as $index => $student)
                                    @php
                                        $scoreValue = $existingGrades[$student->id] ?? '';
                                        $descValue = $existingDescriptions[$student->id] ?? '';
                                    @endphp
                                    <tr class="hover:bg-slate-500/5 transition-colors">
                                        <td class="py-4 px-4 text-center font-semibold text-slate-500">{{ $index + 1 }}</td>
                                        <td class="py-4 px-4">
                                            <p class="font-bold text-slate-800 dark:text-slate-200 uppercase">{{ $student->name }}</p>
                                            <p class="text-[11px] text-slate-500 font-mono mt-0.5">NISN: {{ $student->nisn }}</p>
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <!-- Ukuran input nilai dilebarkan dari w-24 menjadi w-36/w-40 -->
                                            <input type="number" name="scores[{{ $student->id }}]" value="{{ old('scores.'.$student->id, $scoreValue) }}" 
                                                   min="0" max="100" placeholder="0" 
                                                   data-id="{{ $student->id }}"
                                                   class="score-input w-36 mx-auto text-center font-mono text-base font-bold rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 focus:border-emerald-500 focus:ring-emerald-500 py-2.5 px-3">
                                        </td>
                                        <td class="py-4 px-4 text-center">
                                            <input type="text" name="descriptions[{{ $student->id }}]" id="desc_{{ $student->id }}" 
                                                   readonly
                                                   value="{{ old('descriptions.'.$student->id, $descValue) }}"
                                                   placeholder="Otomatis..."
                                                   class="w-48 mx-auto text-center font-semibold rounded-xl border-slate-300 dark:border-slate-700 dark:bg-slate-800/80 dark:text-emerald-400 text-xs p-2.5 bg-slate-100/60 dark:bg-slate-900/40 cursor-not-allowed">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-slate-500 italic">Belum ada siswa terdaftar di kelas ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-6 border-t border-slate-200/60 dark:border-slate-800/60 flex justify-end">
                        <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold shadow-lg shadow-emerald-600/20 transition-all flex items-center space-x-2">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>Simpan Seluruh Nilai</span>
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <!-- Skrip Otomatisasi Predikat Singkat -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const scoreInputs = document.querySelectorAll('.score-input');

            scoreInputs.forEach(input => {
                input.addEventListener('input', function() {
                    const studentId = this.getAttribute('data-id');
                    const descInput = document.getElementById('desc_' + studentId);
                    const score = parseFloat(this.value);

                    if (isNaN(this.value) || this.value.trim() === '') {
                        descInput.value = '';
                        return;
                    }

                    // Logika predikat singkat
                    let text = '';
                    if (score >= 90) {
                        text = 'Sangat Baik';
                    } else if (score >= 80) {
                        text = 'Baik';
                    } else if (score >= 75) {
                        text = 'Cukup';
                    } else {
                        text = 'Perlu Bimbingan';
                    }

                    descInput.value = text;
                });
            });
        });
    </script>
</x-app-layout>