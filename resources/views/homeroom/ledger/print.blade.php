<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ledger Nilai - Kelas {{ $myClass->name }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 1cm;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            color: #000;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
        }
        .header h2 {
            margin: 0;
            font-size: 14px;
            text-transform: uppercase;
        }
        .header p {
            margin: 2px 0;
            font-size: 11px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 10px;
            font-size: 11px;
        }
        .info-table td {
            padding: 2px 0;
        }
        table.ledger-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.ledger-table th, table.ledger-table td {
            border: 1px solid #333;
            padding: 4px 5px;
            text-align: center;
        }
        table.ledger-table th {
            background-color: #e2e8f0;
            font-weight: bold;
            font-size: 9.5px;
            text-transform: uppercase;
        }
        table.ledger-table td.name {
            text-align: left;
            text-transform: uppercase;
            font-weight: bold;
        }
        .signatures {
            width: 100%;
            margin-top: 25px;
            page-break-inside: avoid;
            font-size: 11px;
        }
        .signatures td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }
        .signature-space {
            height: 55px;
        }
        .print-btn-container {
            position: fixed;
            top: 20px;
            right: 20px;
        }
        .print-btn {
            background: #059669;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            font-size: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        @media print {
            .print-btn-container {
                display: none;
            }
        }
        .print-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            border-top: 1px solid #94a3b8;
            padding-top: 6px;
            font-size: 8.5px;
            color: #64748b;
            background: #ffffff;
        }
    </style>
</head>
<body onload="window.print()">

    <!-- Tombol Cetak Manual jika dialog print tidak otomatis -->
    <div class="print-btn-container">
        <a href="javascript:window.print()" class="print-btn">🖨️ Cetak / Simpan PDF</a>
    </div>

    <div class="header">
        <h2>Ledger Rekapitulasi Nilai Hasil Belajar Peserta Didik</h2>
        <p>{{ \App\Models\Setting::get('school_name', 'Nama Sekolah') }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="12%"><strong>Rombel / Kelas</strong></td>
            <td width="38%">: {{ $myClass->name }}</td>
            <td width="12%"><strong>Tahun Ajaran</strong></td>
            <td width="38%">: {{ \App\Models\Setting::get('academic_year', '2025/2026') }}</td>
        </tr>
        <tr>
            <td><strong>Wali Kelas</strong></td>
            <td>: {{ $teacher->name }}</td>
            <td><strong>Semester</strong></td>
            <td>: {{ \App\Models\Setting::get('semester', 'Ganjil') }}</td>
        </tr>
    </table>

    <table class="ledger-table">
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="20%">Nama Peserta Didik</th>
                @foreach($subjects as $subject)
                    <th>{{ Str::limit($subject->name, 10) }}</th>
                @endforeach
                <th width="5%">Total</th>
                <th width="5%">Rata²</th>
                <th width="5%">Rank</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $index => $student)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="name">{{ $student->name }}</td>
                    @foreach($subjects as $subject)
                        <td>{{ $student->studentGrades[$subject->id] ?? 0 }}</td>
                    @endforeach
                    <td><strong>{{ $student->totalScore }}</strong></td>
                    <td><strong>{{ $student->average }}</strong></td>
                    <td><strong>{{ $index + 1 }}</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ 5 + $subjects->count() }}" style="text-align: center; font-style: italic;">Belum ada data siswa.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="signatures">
        <tr>
            <td>
                <p>Mengetahui,</p>
                <p>Kepala Sekolah</p>
                <div class="signature-space"></div>
                <p><strong>{{ \App\Models\Setting::get('headmaster_name', '................................................') }}</strong></p>
                <p>NIP. {{ \App\Models\Setting::get('headmaster_nip', '................................................') }}</p>
            </td>
            <td>
                <p>{{ \App\Models\Setting::get('city', 'Lokasi Sekolah') }}, {{ now()->translatedFormat('d F Y') }}</p>
                <p>Wali Kelas</p>
                <div class="signature-space"></div>
                <p><strong>{{ $teacher->name }}</strong></p>
                <p>NIP. {{ $teacher->nip ?? '................................................' }}</p>
            </td>
        </tr>
    </table>
    <!-- Footer Keterangan Cetak di Bagian Paling Bawah Kertas -->
    <div class="print-footer">
        <table style="width: 100%; border-collapse: collapse; border: none;">
            <tr>
                <td style="text-align: left; border: none; padding: 0;">
                    Dokumen ini dihasilkan dan dicetak secara resmi oleh sistem <strong>{{ \App\Models\Setting::get('school_name', 'e-Rapor ASTS') }}</strong>
                </td>
                <td style="text-align: right; border: none; padding: 0;">
                    Waktu Cetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB
                </td>
            </tr>
        </table>
    </div>
</body>
</html>