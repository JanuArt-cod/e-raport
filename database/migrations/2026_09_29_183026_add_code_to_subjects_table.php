<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            // Menambahkan kolom code jika belum ada
            if (!Schema::hasColumn('subjects', 'code')) {
                $table->string('code')->unique()->after('id')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
};
