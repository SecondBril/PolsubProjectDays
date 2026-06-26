<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('course_classes', 'lecturer_id')) {
            // 1. Cek dan hapus foreign key secara aman menggunakan raw query jika ada
            $fkExists = DB::select("
                SELECT CONSTRAINT_NAME
                FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'course_classes'
                  AND COLUMN_NAME = 'lecturer_id'
                  AND CONSTRAINT_NAME <> 'PRIMARY'
            ");

            if (!empty($fkExists)) {
                Schema::table('course_classes', function (Blueprint $table) {
                    $table->dropForeign(['lecturer_id']);
                });
            }

            // 2. Hapus kolom secara mandiri
            Schema::table('course_classes', function (Blueprint $table) {
                $table->dropColumn('lecturer_id');
            });
        }
    }

    public function down(): void
    {
        Schema::table('course_classes', function (Blueprint $table) {
            if (!Schema::hasColumn('course_classes', 'lecturer_id')) {
                $table->foreignUuid('lecturer_id')->nullable()->constrained('users')->onDelete('cascade');
            }
        });
    }
};
