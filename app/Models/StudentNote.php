<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentNoteData extends Model // (atau StudentNote sesuai nama model yang tergenerate)
{
    use HasFactory;

    protected $table = 'student_notes';

    protected $fillable = [
        'student_id',
        'teacher_id',
        'note',
    ];

    /**
     * Relasi ke Siswa
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * Relasi ke Guru (Wali Kelas) yang menulis
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
