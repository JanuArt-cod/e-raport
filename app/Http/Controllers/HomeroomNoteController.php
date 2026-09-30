<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\StudentNote;
use Illuminate\Http\Request;

class HomeroomNoteController extends Controller
{
    // Menampilkan daftar siswa di kelas binaan beserta catatan mereka
    public function index()
    {
        $teacher = auth()->user();
        $myClass = SchoolClass::with(['students.studentNote'])
                    ->where('homeroom_teacher_id', $teacher->id)
                    ->first();

        return view('homeroom.notes.index', compact('myClass'));
    }

    // Menampilkan halaman form untuk mengisi/mengubah catatan siswa tertentu
    public function edit($studentId)
    {
        $teacher = auth()->user();
        $myClass = SchoolClass::where('homeroom_teacher_id', $teacher->id)->first();

        if (!$myClass) {
            return redirect()->route('homeroom.dashboard')->with('error', 'Anda tidak memiliki kelas binaan.');
        }

        // Pastikan siswa berada di kelas binaan wali kelas yang login
        $student = $myClass->students()->where('id', $studentId)->firstOrFail();
        $studentNote = StudentNote::where('student_id', $student->id)->first();

        return view('homeroom.notes.edit', compact('student', 'studentNote'));
    }

    // Menyimpan atau memperbarui catatan ke database
    public function update(Request $request, $studentId)
    {
        $request->validate([
            'note' => 'nullable|string|max:1000',
        ]);

        $teacher = auth()->user();
        $myClass = SchoolClass::where('homeroom_teacher_id', $teacher->id)->first();

        if (!$myClass) {
            return redirect()->route('homeroom.dashboard')->with('error', 'Anda tidak memiliki akses.');
        }

        $student = $myClass->students()->where('id', $studentId)->firstOrFail();

        StudentNote::updateOrCreate(
            ['student_id' => $student->id],
            [
                'teacher_id' => $teacher->id,
                'note' => $request->note,
            ]
        );

        return redirect()->route('homeroom.notes.index')->with('success', 'Catatan perkembangan siswa berhasil diperbarui!');
    }
}
