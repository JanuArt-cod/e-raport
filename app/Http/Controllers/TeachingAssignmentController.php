<?php

namespace App\Http\Controllers;

use App\Models\TeachingAssignment;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;

class TeachingAssignmentController extends Controller
{
    public function index()
    {
        $assignments = TeachingAssignment::with(['teacher', 'schoolClass', 'subject'])->latest()->paginate(10);
        return view('admin.assignments.index', compact('assignments'));
    }

    public function create()
    {
        // Ambil guru yang rolenya 'guru' atau 'wali_kelas'
        $teachers = User::whereIn('role', ['guru', 'wali_kelas'])->get();
        $classes = SchoolClass::all();
        $subjects = Subject::all();

        return view('admin.assignments.create', compact('teachers', 'classes', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        // Cek duplikasi penugasan agar tidak ganda
        $exists = TeachingAssignment::where('user_id', $request->user_id)
            ->where('class_id', $request->class_id)
            ->where('subject_id', $request->subject_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Penugasan mengajar tersebut sudah ada di dalam sistem!');
        }

        TeachingAssignment::create($request->all());

        return redirect()->route('admin.assignments.index')->with('success', 'Penugasan mengajar berhasil ditambahkan!');
    }

    public function destroy(TeachingAssignment $assignment)
    {
        $assignment->delete();
        return redirect()->route('admin.assignments.index')->with('success', 'Penugasan mengajar berhasil dihapus!');
    }
}
