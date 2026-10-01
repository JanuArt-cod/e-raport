<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeachingAssignment;
use App\Models\SchoolClass;
use App\Models\Grade;
use App\Models\StudentNote;

class AdminMonitoringController extends Controller
{
    public function index()
    {
        // 1. Monitoring Input Nilai Guru Mapel (Ubah 'user' menjadi 'teacher')
        $assignments = TeachingAssignment::with(['teacher', 'schoolClass.students', 'subject'])->get();

        foreach ($assignments as $assignment) {
            $totalStudents = $assignment->schoolClass->students->count();
            $gradedCount = Grade::where('class_id', $assignment->class_id)
                ->where('subject_id', $assignment->subject_id)
                ->whereNotNull('score')
                ->where('score', '!=', '')
                ->count();

            $percentage = $totalStudents > 0 ? round(($gradedCount / $totalStudents) * 100) : 0;
            
            $status = 'Belum Input';
            $statusClass = 'text-rose-600 dark:text-rose-400 bg-rose-500/10 border-rose-500/20';

            if ($totalStudents > 0 && $gradedCount >= $totalStudents) {
                $status = 'Lengkap';
                $statusClass = 'text-emerald-600 dark:text-emerald-400 bg-emerald-500/10 border-emerald-500/20';
            } elseif ($gradedCount > 0) {
                $status = 'Kurang Lengkap';
                $statusClass = 'text-amber-600 dark:text-amber-400 bg-amber-500/10 border-amber-500/20';
            }

            $assignment->total_students = $totalStudents;
            $assignment->graded_count = $gradedCount;
            $assignment->percentage = $percentage;
            $assignment->status_label = $status;
            $assignment->status_class = $statusClass;
        }

        // 2. Monitoring Input Catatan Wali Kelas
        $classes = SchoolClass::with(['students', 'homeroomTeacher'])->get();

        foreach ($classes as $class) {
            $totalStudents = $class->students->count();
            $notedCount = 0;

            if ($totalStudents > 0) {
                $studentIds = $class->students->pluck('id');
                // Ubah 'notes' menjadi 'note'
                $notedCount = StudentNote::whereIn('student_id', $studentIds)
                    ->whereNotNull('note')
                    ->where('note', '!=', '')
                    ->count();
            }

            $notePercentage = $totalStudents > 0 ? round(($notedCount / $totalStudents) * 100) : 0;
            
            $noteStatus = 'Belum Input';
            $noteStatusClass = 'text-rose-600 dark:text-rose-400 bg-rose-500/10 border-rose-500/20';

            if ($totalStudents > 0 && $notedCount >= $totalStudents) {
                $noteStatus = 'Lengkap';
                $noteStatusClass = 'text-emerald-600 dark:text-emerald-400 bg-emerald-500/10 border-emerald-500/20';
            } elseif ($notedCount > 0) {
                $noteStatus = 'Kurang Lengkap';
                $noteStatusClass = 'text-amber-600 dark:text-amber-400 bg-amber-500/10 border-amber-500/20';
            }

            $class->total_students = $totalStudents;
            $class->noted_count = $notedCount;
            $class->note_percentage = $notePercentage;
            $class->note_status = $noteStatus;
            $class->note_status_class = $noteStatusClass;
        }

        return view('admin.monitoring', compact('assignments', 'classes'));
}
}
