<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Grade;
use Illuminate\Http\Request;

class HomeroomTeacherGradeMonitorController extends Controller
{
    public function index()
    {
        $teacher = auth()->user();

        // Ambil kelas binaan wali kelas beserta siswanya
        $myClass = SchoolClass::with(['students'])
                    ->where('homeroom_teacher_id', $teacher->id)
                    ->first();

        if (!$myClass) {
            return redirect()->route('homeroom.dashboard')->with('error', 'Anda belum ditugaskan ke kelas manapun.');
        }

        $subjects = Subject::all();
        $studentsCount = $myClass->students->count();
        $studentIds = $myClass->students->pluck('id');

        $monitoringData = [];
        foreach ($subjects as $subject) {
            $gradedCount = Grade::where('subject_id', $subject->id)
                            ->whereIn('student_id', $studentIds)
                            ->whereNotNull('score')
                            ->count();

            $status = 'Belum';
            if ($studentsCount > 0 && $gradedCount >= $studentsCount) {
                $status = 'Selesai';
            } elseif ($gradedCount > 0) {
                $status = 'Sebagian';
            }

            // Hitung persentase progres (0 - 100%)
            $percentage = $studentsCount > 0 ? round(($gradedCount / $studentsCount) * 100) : 0;

            $monitoringData[] = [
                'subject' => $subject,
                'graded_count' => $gradedCount,
                'total_students' => $studentsCount,
                'percentage' => $percentage,
                'status' => $status
            ];
        }

        // Siapkan data untuk Chart.js
        $chartLabels = collect($monitoringData)->pluck('subject.name');
        $chartData = collect($monitoringData)->pluck('percentage');

        return view('homeroom.grading.index', compact('myClass', 'monitoringData', 'chartLabels', 'chartData'));
    }
}