<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\TeachingAssignment;
use App\Models\Grade;
use Illuminate\Http\Request;

class HomeroomTeacherController extends Controller
{
    public function index()
    {
        $teacher = auth()->user();

        // 1. Ambil data kelas binaan wali kelas
        $homeroomClass = SchoolClass::with(['students.grades', 'students.studentNote'])
                    ->where('homeroom_teacher_id', $teacher->id)
                    ->first();

        // 2. Ambil data mata pelajaran yang diampu sebagai guru mapel
        $teachingAssignments = TeachingAssignment::with(['schoolClass.students', 'subject'])
            ->where('user_id', $teacher->id)
            ->get();

        // 3. Hitung progres pengisian nilai untuk setiap mapel yang diampu
        foreach ($teachingAssignments as $assignment) {
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

            $assignment->total_students = $totalStudents;
            $assignment->graded_count = $gradedCount;
            $assignment->percentage = $percentage;
            $assignment->status_label = $statusLabel;
            $assignment->status_class = $statusClass;
        }

        return view('homeroom.dashboard', compact('homeroomClass', 'teachingAssignments'));
    }
    // Menampilkan daftar pilihan mata pelajaran yang diampu oleh Wali Kelas
    public function nilaiIndex()
    {
        $teacher = auth()->id();

        $teachingAssignments = TeachingAssignment::with(['schoolClass.students', 'subject'])
            ->where('user_id', $teacher)
            ->get();

        foreach ($teachingAssignments as $assignment) {
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

            $assignment->total_students = $totalStudents;
            $assignment->graded_count = $gradedCount;
            $assignment->percentage = $percentage;
            $assignment->status_label = $statusLabel;
            $assignment->status_class = $statusClass;
        }

        return view('homeroom.nilai-index', compact('teachingAssignments'));
    }
}
