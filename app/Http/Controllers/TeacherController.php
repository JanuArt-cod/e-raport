<?php

namespace App\Http\Controllers;

use App\Models\TeachingAssignment;
use App\Models\Student;
use App\Models\Grade;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    // 1. Menampilkan daftar kelas & mapel yang diampu oleh guru yang sedang login
    public function index()
    {
        $teacherId = auth()->id();
        
        // Ambil data penugasan beserta relasi kelas, siswa, dan mapel
        $assignments = TeachingAssignment::with(['schoolClass.students', 'subject'])
            ->where('user_id', $teacherId)
            ->get();

        // Hitung progres pengisian nilai untuk setiap penugasan kelas
        foreach ($assignments as $assignment) {
            $classId = $assignment->class_id;
            $subjectId = $assignment->subject_id;

            $totalStudents = $assignment->schoolClass->students->count();
            
            $gradedCount = Grade::where('class_id', $classId)
                ->where('subject_id', $subjectId)
                ->whereNotNull('score')
                ->where('score', '!=', '')
                ->count();

            $percentage = $totalStudents > 0 ? round(($gradedCount / $totalStudents) * 100) : 0;

            $statusLabel = 'Belum Input';
            $statusClass = 'text-rose-600 dark:text-rose-400 bg-rose-500/10 border-rose-500/20';

            if ($totalStudents > 0 && $gradedCount >= $totalStudents) {
                $statusLabel = 'Lengkap';
                $statusClass = 'text-emerald-600 dark:text-emerald-400 bg-emerald-500/10 border-emerald-500/20';
            } elseif ($gradedCount > 0) {
                $statusLabel = 'Kurang Lengkap';
                $statusClass = 'text-amber-600 dark:text-amber-400 bg-amber-500/10 border-amber-500/20';
            }

            // Masukkan atribut tambahan ke objek assignment
            $assignment->total_students = $totalStudents;
            $assignment->graded_count = $gradedCount;
            $assignment->percentage = $percentage;
            $assignment->status_label = $statusLabel;
            $assignment->status_class = $statusClass;
        }

        return view('guru.dashboard', compact('assignments'));
    }

    // 2. Menampilkan form input nilai untuk kelas dan mapel tertentu
    public function inputForm($classId, $subjectId)
    {
        $teacherId = auth()->id();

        // Validasi apakah guru benar-benar mengampu kelas & mapel ini
        $assignment = TeachingAssignment::where('user_id', $teacherId)
            ->where('class_id', $classId)
            ->where('subject_id', $subjectId)
            ->with(['schoolClass', 'subject'])
            ->firstOrFail();

        // Ambil daftar siswa di kelas tersebut
        $students = Student::where('class_id', $classId)->orderBy('name', 'asc')->get();

        // Ambil nilai yang sudah pernah diinput sebelumnya (jika ada)
        $existingGrades = Grade::where('class_id', $classId)
            ->where('subject_id', $subjectId)
            ->pluck('score', 'student_id'); // Format: [student_id => score]

        // Ambil deskripsi capaian kompetensi yang sudah pernah diinput sebelumnya (jika ada)
        $existingDescriptions = Grade::where('class_id', $classId)
            ->where('subject_id', $subjectId)
            ->pluck('description', 'student_id'); // Format: [student_id => description]

        return view('guru.input-nilai', compact('assignment', 'students', 'existingGrades', 'existingDescriptions', 'classId', 'subjectId'));
    }

    // 3. Menyimpan nilai siswa secara massal (Bulk Store)
    public function storeGrades(Request $request, $classId, $subjectId)
    {
        $teacherId = auth()->id();

        $request->validate([
            'scores' => 'required|array',
            'scores.*' => 'nullable|numeric|min:0|max:100',
            'descriptions' => 'nullable|array',
        ]);

        foreach ($request->scores as $studentId => $score) {
            $description = $request->descriptions[$studentId] ?? null;

            if ($score !== null && $score !== '') {
                Grade::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'subject_id' => $subjectId,
                        'class_id'   => $classId,
                    ],
                    [
                        'teacher_id'  => $teacherId,
                        'score'       => $score,
                        'description' => $description,
                    ]
                );
            } else {
                Grade::where('student_id', $studentId)
                    ->where('subject_id', $subjectId)
                    ->where('class_id', $classId)
                    ->delete();
            }
        }

        // REDIREKSI DINAMIS: Cek apakah yang login wali_kelas atau guru biasa
        $redirectRoute = (auth()->user()->role === 'wali_kelas') ? 'homeroom.nilai.input' : 'guru.nilai.input';

        return redirect()->route($redirectRoute, [$classId, $subjectId])
            ->with('success', 'Nilai dan Capaian Kompetensi berhasil disimpan!');
    }
    // 4. Menampilkan halaman rekapitulasi dan cetak daftar nilai mapel
    public function rekapNilai($classId, $subjectId)
    {
        $teacherId = auth()->id();

        // Validasi hak akses guru terhadap kelas & mapel
        $assignment = TeachingAssignment::where('user_id', $teacherId)
            ->where('class_id', $classId)
            ->where('subject_id', $subjectId)
            ->with(['schoolClass', 'subject'])
            ->firstOrFail();

        // Ambil daftar siswa
        $students = Student::where('class_id', $classId)->orderBy('name', 'asc')->get();

        // Ambil data nilai berdasarkan mapel dan kelas
        $grades = Grade::where('class_id', $classId)
            ->where('subject_id', $subjectId)
            ->get()
            ->keyBy('student_id');

        // Hitung statistik kelas
        $scoredValues = $grades->pluck('score')->filter(fn($val) => $val !== null && $val !== '');
        $totalSiswa = $students->count();
        $totalSudahDinilai = $scoredValues->count();
        $rataRata = $totalSudahDinilai > 0 ? round($scoredValues->avg(), 1) : 0;
        $nilaiTertinggi = $totalSudahDinilai > 0 ? $scoredValues->max() : 0;
        $nilaiTerendah = $totalSudahDinilai > 0 ? $scoredValues->min() : 0;

        return view('guru.rekap-nilai', compact(
            'assignment', 'students', 'grades', 
            'totalSiswa', 'totalSudahDinilai', 'rataRata', 
            'nilaiTertinggi', 'nilaiTerendah', 'classId', 'subjectId'
        ));
    }
    // Menampilkan daftar pilihan kelas & mapel untuk rekapitulasi dari Navbar
    public function rekapIndex()
    {
        $teacherId = auth()->id();
        
        $assignments = TeachingAssignment::with(['schoolClass', 'subject'])
            ->where('user_id', $teacherId)
            ->get();

        return view('guru.rekap-index', compact('assignments'));
    }
}
