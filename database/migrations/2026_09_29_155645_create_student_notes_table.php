<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_notes', function (Blueprint $table) {
            $table->id();
            // Mengarah ke siswa yang diberi catatan
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            // Mengarah ke guru (wali kelas) yang menulis catatan
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            // Isi catatan/pesan dari wali kelas
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_notes');
    }
};
