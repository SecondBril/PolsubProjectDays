<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_classes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignUuid('semester_id')->constrained('semesters')->cascadeOnDelete();
            $table->foreignUuid('lecturer_id')->constrained('users')->restrictOnDelete(); // Dosen Pengampu

            $table->string('class_code', 50)->nullable(); // Misal: SI-2A, TRPL-1B
            $table->timestamps();

            // Mencegah duplikasi kelas yang sama di semester yang sama dengan dosen yang sama
            $table->unique(['course_id', 'semester_id', 'lecturer_id', 'class_code'], 'unique_class_offering');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_classes');
    }
};
