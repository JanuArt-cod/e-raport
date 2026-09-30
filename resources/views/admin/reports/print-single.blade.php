<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Rapor ASTS - {{ $student->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { print-color-adjust: exact; -webkit-print-color-adjust: exact; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-white text-slate-800 p-8 max-w-3xl mx-auto text-xs font-sans">

    <!-- Tombol Aksi Cetak (Hilang saat diprint) -->
    <div class="no-print mb-6 flex justify-between items-center bg-slate-100 p-4 rounded-xl border border-slate-200">
        <span class="font-semibold text-slate-600">Pratinjau Lembar Rapor Sisipan ASTS</span>
        <div class="space-x-3">
            <button onclick="window.print()" class="px-5 py-2 rounded-lg bg-emerald-600 text-white font-semibold shadow hover:bg-emerald-700 transition-all cursor-pointer">
                🖨️ Cetak / Print PDF
            </button>
            <a href="javascript:window.close()" class="px-4 py-2 rounded-lg bg-slate-300 text-slate-700 font-semibold hover:bg-slate-400 transition-all">Tutup</a>
        </div>
    </div>

    <!-- Kop Surat Dinamis dengan Logo -->
        <table class="w-full border-b-2 border-slate-800 pb-4 mb-6">
            <tr>
                <!-- Kolom Logo -->
                <td class="w-20 align-middle text-center">
                    @if(\App\Models\Setting::get('school_logo'))
                        <img src="{{ asset(\App\Models\Setting::get('school_logo')) }}" alt="Logo Sekolah" class="w-16 h-16 object-contain mx-auto">
                    @else
                        <div class="w-16 h-16 border border-dashed border-slate-400 flex items-center justify-center text-[9px] text-slate-400 mx-auto">Logo</div>
                    @endif
                </td>
                <!-- Kolom Teks Kop Surat -->
                <td class="text-center align-middle px-2">
                    <h2 class="text-xs font-bold uppercase tracking-wider">{{ \App\Models\Setting::get('government_name', 'PEMERINTAH KOTA / DINAS PENDIDIKAN') }}</h2>
                    <h1 class="text-base font-extrabold uppercase tracking-wide">{{ \App\Models\Setting::get('school_name', 'SMP / M.Ts NEGERI E-RAPOR ASTS') }}</h1>
                    <p class="text-[10px] text-slate-600 font-medium">{{ \App\Models\Setting::get('school_address', 'Alamat Sekolah Belum Diatur') }}</p>
                    <p class="text-[10px] text-slate-500 mt-0.5">Tahun Ajaran {{ \App\Models\Setting::get('academic_year', '2025/2026') }} • Semester {{ \App\Models\Setting::get('semester', 'Ganjil') }}</p>
                </td>
                <!-- Kolom Pengimbang Kanan agar Teks Pas di Tengah -->
                <td class="w-20"></td>
            </tr>
        </table>

    <!-- Judul Dokumen -->
    <div class="text-center mb-6">
        <h3 class="text-sm font-bold uppercase underline underline-offset-4">HASIL PENILAIAN ASESMEN SUMATIF TENGAH SEMESTER (ASTS)</h3>
    </div>

    <!-- Identitas Siswa -->
    <table class="w-full mb-6 font-medium">
        <tr>
            <td class="w-32 py-1">Nama Peserta Didik</td>
            <td class="w-4 py-1">:</td>
            <td class="font-bold uppercase">{{ $student->name }}</td>
            <td class="w-28 py-1">Kelas</td>
            <td class="w-4 py-1">:</td>
            <td class="font-bold">Kelas {{ $student->schoolClass->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="py-1">Nomor Induk / NISN</td>
            <td class="py-1">:</td>
            <td>{{ $student->nisn }}</td>
            <td class="py-1">Semester</td>
            <td class="py-1">:</td>
            <td>{{ \App\Models\Setting::get('semester', 'Ganjil') }}</td>
        </tr>
    </table>

    <!-- Tabel Nilai Mapel -->
    <table class="w-full border-collapse border border-slate-800 mb-8">
        <!-- Tabel Nilai Mapel dengan Capaian Kompetensi Otomatis -->
        <table class="w-full border-collapse border border-slate-800 mb-8">
            <thead>
                <tr class="bg-slate-100 text-slate-900 font-bold uppercase text-[11px]">
                    <th class="border border-slate-800 py-2.5 px-3 w-12 text-center">No</th>
                    <th class="border border-slate-800 py-2.5 px-3">Mata Pelajaran</th>
                    <th class="border border-slate-800 py-2.5 px-3 w-28 text-center">Nilai ASTS</th>
                    <th class="border border-slate-800 py-2.5 px-3">Capaian Kompetensi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subjects as $index => $subj)
                    @php
                        $score = $grades[$subj->id] ?? null;
                        $competency = '-';

                        if ($score !== null) {
                            if ($score >= 90) {
                                $competency = 'Menunjukkan penguasaan yang Sangat Baik dalam memahami dan menguasai seluruh materi ' . $subj->name . '.';
                            } elseif ($score >= 80) {
                                $competency = 'Menunjukkan penguasaan yang Baik dalam memahami sebagian besar materi ' . $subj->name . '.';
                            } elseif ($score >= 70) {
                                $competency = 'Menunjukkan penguasaan yang Cukup dalam memahami materi dasar ' . $subj->name . ', namun perlu penguatan pada beberapa sub-materi.';
                            } else {
                                $competency = 'Memerlukan bimbingan dan pendampingan intensif dalam memahami materi ' . $subj->name . '.';
                            }
                        } else {
                            $competency = 'Belum ada nilai yang diinput oleh guru pengampu.';
                        }
                    @endphp
                    <tr>
                        <td class="border border-slate-800 py-2 px-3 text-center">{{ $index + 1 }}</td>
                        <td class="border border-slate-800 py-2 px-3 font-medium">{{ $subj->name }}</td>
                        <td class="border border-slate-800 py-2 px-3 text-center font-bold text-sm">{{ $score !== null ? $score : '-' }}</td>
                        <td class="border border-slate-800 py-2 px-3 italic text-slate-700 text-[11px] leading-relaxed">{{ $competency }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </table>
<!-- Catatan Wali Kelas: Model Formal Ber-Header -->
    <div class="mb-8 border border-slate-800 rounded-md overflow-hidden page-break-inside-avoid">
        <div class="bg-slate-100 px-3 py-1.5 border-b border-slate-800 font-bold uppercase text-[11px] text-slate-900">
            Catatan Wali Kelas
        </div>
        <div class="p-3 italic text-slate-800 text-xs min-h-[50px] leading-relaxed bg-white">
            {{ $studentNote->note ?? '' }}
        </div>
    </div>
    <!-- 3 Kolom Tanda Tangan (Orang Tua, Wali Kelas, Kepala Sekolah) -->
    <table class="w-full pt-8 mt-12 page-break-inside-avoid text-center font-medium">
        <tr>
            <!-- Kolom 1: Orang Tua / Wali Murid -->
            <td class="w-1/3 align-top">
                <p>Mengetahui,</p>
                <p class="font-bold">Kepala Sekolah</p>
                <div class="h-16"></div>
                <p class="font-bold underline">{{ \App\Models\Setting::get('headmaster_name', 'Nama Kepala Sekolah') }}</p>
                <p class="text-[10px]">NIP. {{ \App\Models\Setting::get('headmaster_nip', '-') }}</p>
                
            </td>

            <!-- Kolom 2: Wali Kelas (Dinamis dari Data Kelas) -->
            <td class="w-1/3 align-top">
                <p>&nbsp;</p>
                <p class="font-bold">Orang Tua / Wali Murid</p>
                <div class="h-16"></div>
                <p class="border-b border-slate-800 w-40 mx-auto font-semibold">( ........................................ )</p>
            </td>

            <!-- Kolom 3: Kepala Sekolah (Dinamis dari Setting & Tanggal Otomatis) -->
            <td class="w-1/3 align-top">
                <p>Bogor, {{ now()->translatedFormat('d F Y') }}</p>
                <p class="font-bold">Wali Kelas {{ $student->schoolClass->name ?? '' }}</p>
                <div class="h-16"></div>
                <p class="font-bold underline">{{ $student->schoolClass->homeroomTeacher->name ?? 'Belum Ditentukan' }}</p>
                <p class="text-[10px]">NIP. {{ $student->schoolClass->homeroomTeacher->nip ?? '-' }}</p>
            </td>
        </tr>
    </table>
    <!-- Footer Keterangan Cetak Sistem -->
    <div class="mt-12 pt-4 border-t border-slate-300 text-[9px] text-slate-500 flex justify-between items-center page-break-inside-avoid">
        <span>Dokumen ini dihasilkan dan dicetak secara resmi oleh sistem <strong>{{ \App\Models\Setting::get('school_name', 'e-Rapor ASTS') }}</strong></span>
        <span>Waktu Cetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB</span>
    </div>
</body>
</html>