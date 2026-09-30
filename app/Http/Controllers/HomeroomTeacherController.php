<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

class HomeroomTeacherController extends Controller
{
    public function index()
    {
        $teacher = auth()->user();

        // Ambil kelas yang dibina oleh wali kelas yang sedang login, beserta data siswanya
        $myClass = SchoolClass::with(['students.grades', 'students.studentNote'])
                    ->where('homeroom_teacher_id', $teacher->id)
                    ->first();

        return view('homeroom.dashboard', compact('myClass'));
    }
}
