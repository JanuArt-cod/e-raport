<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    // Tambahkan properti fillable ini agar mengizinkan mass assignment
    protected $fillable = [
        'student_id',
        'subject_id',
        'class_id',
        'teacher_id',
        'score',
        'description', // Tambahkan ini
    ];
}
