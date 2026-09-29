<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolClassController;
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
    }

    abort(403, 'Role tidak dikenali.');
})->name('dashboard');

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
});

// Dashboard Panitia Ujian
Route::middleware(['auth', 'role:panitia'])->prefix('panitia')->name('panitia.')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.panitia');
    })->name('dashboard');
});

Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'index'])->name('dashboard');
    Route::get('/nilai/input/{classId}/{subjectId}', [TeacherController::class, 'inputForm'])->name('nilai.input');
    Route::post('/nilai/store/{classId}/{subjectId}', [TeacherController::class, 'storeGrades'])->name('nilai.store');
});

require __DIR__.'/auth.php';
