<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Subject;

class AdminController extends Controller
{
    public function index()
    {
        // Mengambil data statistik master
        $totalStudents = Student::count();
        $totalTeachers = User::where('role', 'guru')->count();
        $totalClasses = SchoolClass::count();
        $totalSubjects = Subject::count();

        return view('dashboard.admin', compact(
            'totalStudents', 
            'totalTeachers', 
            'totalClasses', 
            'totalSubjects'
        ));
    }
}
