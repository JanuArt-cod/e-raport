<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;

class HomeroomLedgerController extends Controller
{
    public function index()
    {
        $teacher = auth()->user();

        // Ambil kelas binaan wali kelas beserta siswa dan nilai mereka
        $myClass = SchoolClass::with(['students.grades', 'students.studentNote'])
                    ->where('homeroom_teacher_id', $teacher->id)
                    ->first();

        if (!$myClass) {
            return redirect()->route('homeroom.dashboard')->with('error', 'Anda belum ditugaskan ke kelas manapun.');
        }

        // Ambil daftar seluruh mata pelajaran yang tersedia di sistem
        $subjects = Subject::all();

        // Hitung total nilai, rata-rata, dan susun peringkat (ranking) siswa di kelas
        $students = $myClass->students->map(function ($student) use ($subjects) {
            $totalScore = 0;
            $countSubject = $subjects->count();
            
            // Petakan nilai per mata pelajaran untuk siswa ini
            $studentGrades = [];
            foreach ($subjects as $subject) {
                // Cari nilai berdasarkan subject_id (sesuaikan jika kolom relasi Anda berbeda, misal mapel_id)
                $grade = $student->grades->where('subject_id', $subject->id)->first();
                $score = $grade ? $grade->score : 0;
                
                $studentGrades[$subject->id] = $score;
                $totalScore += $score;
            }

            $average = $countSubject > 0 ? round($totalScore / $countSubject, 2) : 0;

            $student->studentGrades = $studentGrades;
            $student->totalScore = $totalScore;
            $student->average = $average;

            return $student;
        })->sortByDesc('average')->values(); // Urutkan dari rata-rata tertinggi ke terendah untuk ranking

        return view('homeroom.ledger.index', compact('myClass', 'subjects', 'students'));
    }
    // Menampilkan halaman cetak ledger khusus wali kelas
    public function printLedger()
    {
        $teacher = auth()->user();

        $myClass = SchoolClass::with(['students.grades'])
                    ->where('homeroom_teacher_id', $teacher->id)
                    ->first();

        if (!$myClass) {
            return redirect()->route('homeroom.dashboard')->with('error', 'Anda belum ditugaskan ke kelas manapun.');
        }

        $subjects = Subject::all();

        $students = $myClass->students->map(function ($student) use ($subjects) {
            $totalScore = 0;
            $countSubject = $subjects->count();
            
            $studentGrades = [];
            foreach ($subjects as $subject) {
                $grade = $student->grades->where('subject_id', $subject->id)->first();
                $score = $grade ? $grade->score : 0;
                
                $studentGrades[$subject->id] = $score;
                $totalScore += $score;
            }

            $average = $countSubject > 0 ? round($totalScore / $countSubject, 2) : 0;

            $student->studentGrades = $studentGrades;
            $student->totalScore = $totalScore;
            $student->average = $average;

            return $student;
        })->sortByDesc('average')->values();

        return view('homeroom.ledger.print', compact('myClass', 'subjects', 'students', 'teacher'));
    }
}
