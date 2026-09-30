<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeroomLedgerController;
use App\Http\Controllers\HomeroomNoteController;
use App\Http\Controllers\HomeroomTeacherController;
use App\Http\Controllers\HomeroomTeacherGradeMonitorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeachingAssignmentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

// Rute Pintar / Traffic Controller untuk nama 'dashboard'
Route::middleware(['auth'])->get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'panitia') {
        return redirect()->route('panitia.dashboard');
    } elseif ($user->role === 'guru') {
        return redirect()->route('guru.dashboard');
    } elseif ($user->role === 'wali_kelas') {
        return redirect()->route('homeroom.dashboard');
    }

    abort(403, 'Role tidak dikenali.');
})->name('dashboard');


// Rute Cetak Rapor (Dapat diakses oleh Admin & Wali Kelas)
Route::middleware(['auth'])->group(function () {
    Route::get('/reports/print/{studentId}', [ReportController::class, 'printStudent'])->name('admin.reports.print');
});

// Dashboard Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    // CRUD Manajemen Pengguna
    Route::resource('users', UserController::class);
    // CRUD Manajemen Kelas (Rombel)
    Route::resource('classes', SchoolClassController::class);
    // CRUD Siswa + Import & Template Excel
    Route::get('students/template', [StudentController::class, 'downloadTemplate'])->name('students.template');
    Route::post('students/import', [StudentController::class, 'import'])->name('students.import');
    Route::resource('students', StudentController::class);

    // CRUD Mata Pelajaran & Mapping Penugasan Mengajar
    Route::resource('subjects', SubjectController::class);
    Route::resource('assignments', TeachingAssignmentController::class);

    // Modul Rekapitulasi & Cetak Rapor ASTS oleh Panitia/Admin
    Route::get('/rekap', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/rekap/kelas/{classId}', [ReportController::class, 'classDetail'])->name('reports.class-detail');
    Route::get('/rekap/cetak/{studentId}', [ReportController::class, 'printStudent'])->name('reports.print-student');

    // Rute Pengaturan Sistem & Raport Cetak
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
});

// Dashboard Panitia Ujian
Route::middleware(['auth', 'role:panitia'])->prefix('panitia')->name('panitia.')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.panitia');
    })->name('dashboard');
});

Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    // Dashboard Guru
    Route::get('/dashboard', [TeacherController::class, 'index'])->name('dashboard');

    // Gunakan nama 'nilai.input' dan 'nilai.store'
    Route::get('/nilai/input/{classId}/{subjectId}', [TeacherController::class, 'inputForm'])->name('nilai.input');
    Route::post('/nilai/input/{classId}/{subjectId}', [TeacherController::class, 'storeGrades'])->name('nilai.store');
    // Rute Indeks Rekap untuk Navbar & Rute Detail Rekap
    Route::get('/nilai/rekap', [TeacherController::class, 'rekapIndex'])->name('nilai.rekap.index');
    Route::get('/nilai/rekap/{classId}/{subjectId}', [TeacherController::class, 'rekapNilai'])->name('nilai.rekap');
});

Route::middleware(['auth', 'role:wali_kelas'])->prefix('homeroom')->name('homeroom.')->group(function () {
    Route::get('/dashboard', [HomeroomTeacherController::class, 'index'])->name('dashboard');
    // CRUD Catatan Wali Kelas Terpisah
    Route::get('/notes', [HomeroomNoteController::class, 'index'])->name('notes.index');
    Route::get('/notes/{studentId}/edit', [HomeroomNoteController::class, 'edit'])->name('notes.edit');
    Route::put('/notes/{studentId}', [HomeroomNoteController::class, 'update'])->name('notes.update');
    // Ledger Nilai Kelas
    Route::get('/ledger', [HomeroomLedgerController::class, 'index'])->name('ledger.index');
    Route::get('/ledger/print', [HomeroomLedgerController::class, 'printLedger'])->name('ledger.print');
    Route::get('/grading-monitor', [HomeroomTeacherGradeMonitorController::class, 'index'])->name('grading.index');
});


require __DIR__.'/auth.php';
