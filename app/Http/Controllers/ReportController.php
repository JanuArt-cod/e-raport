<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\StudentNote;
use App\Models\Subject;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // 1. Menampilkan daftar kelas untuk rekapitulasi
    public function index()
    {
        $classes = SchoolClass::withCount('students')->get();
        return view('admin.reports.index', compact('classes'));
    }

    // 2. Menampilkan detail rekapitulasi matriks nilai per kelas
    public function classDetail($classId)
    {
        $schoolClass = SchoolClass::findOrFail($classId);
        $students = Student::where('class_id', $classId)->orderBy('name', 'asc')->get();
        $subjects = Subject::all();
        
        // Ambil semua nilai untuk kelas ini, susun dalam format: [student_id => [subject_id => score]]
        $grades = Grade::where('class_id', $classId)->get()->groupBy('student_id');
        $gradeMap = [];
        foreach ($grades as $studentId => $studentGrades) {
            $gradeMap[$studentId] = $studentGrades->pluck('score', 'subject_id')->toArray();
        }

        return view('admin.reports.class-detail', compact('schoolClass', 'students', 'subjects', 'gradeMap'));
    }

    // Menampilkan halaman cetak rapor per siswa
    public function printStudent($studentId)
    {
        $student = Student::with(['schoolClass.homeroomTeacher'])->findOrFail($studentId);
        $subjects = Subject::all();
        
        $grades = Grade::where('student_id', $studentId)->pluck('score', 'subject_id')->toArray();

        // Mengambil catatan berdasarkan model StudentNote
        $studentNote = StudentNote::where('student_id', $studentId)->first();

        return view('admin.reports.print-single', compact('student', 'subjects', 'grades', 'studentNote'));
    }
    // Menyimpan atau memperbarui catatan wali kelas
    public function saveNote(Request $request, $studentId)
    {
        $request->validate([
            'note' => 'nullable|string|max:500',
        ]);

        StudentNote::updateOrCreate(
            ['student_id' => $studentId],
            [
                'teacher_id' => auth()->id(), // Menyimpan ID guru/admin yang sedang login
                'note' => $request->note,
            ]
        );

        return back()->with('success', 'Catatan wali kelas berhasil disimpan!');
    }
}
