<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            // Menambahkan foreign key wali kelas yang mengarah ke tabel users
            $table->foreignId('homeroom_teacher_id')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->dropForeign(['homeroom_teacher_id']);
            $table->dropColumn('homeroom_teacher_id');
        });
    }
};
