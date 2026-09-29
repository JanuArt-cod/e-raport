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
        
        // Ambil data penugasan berdasarkan guru yang login
        $assignments = TeachingAssignment::with(['schoolClass', 'subject'])
            ->where('user_id', $teacherId)
            ->get();

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

        return view('guru.input-nilai', compact('assignment', 'students', 'existingGrades', 'classId', 'subjectId'));
    }

    // 3. Menyimpan nilai siswa secara massal (Bulk Store)
    public function storeGrades(Request $request, $classId, $subjectId)
    {
        $teacherId = auth()->id();

        // Validasi input skor (tiap nilai berupa angka antara 0 sampai 100)
        $request->validate([
            'scores' => 'required|array',
            'scores.*' => 'nullable|numeric|min:0|max:100',
        ]);

        foreach ($request->scores as $studentId => $score) {
            // Jika kolom nilai tidak kosong (atau bernilai 0), simpan/perbarui
            if ($score !== null && $score !== '') {
                Grade::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'subject_id' => $subjectId,
                        'class_id'   => $classId,
                    ],
                    [
                        'teacher_id' => $teacherId,
                        'score'      => $score,
                    ]
                );
            } else {
                // Jika dikosongkan oleh guru, hapus data nilainya jika sebelumnya pernah ada
                Grade::where('student_id', $studentId)
                    ->where('subject_id', $subjectId)
                    ->where('class_id', $classId)
                    ->delete();
            }
        }

        return redirect()->route('guru.dashboard')->with('success', 'Nilai ASTS berhasil disimpan!');
    }
}
