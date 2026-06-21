<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('semesters', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 50); // Genap 2025/2026
            $table->year('year');
            $table->enum('term', ['GANJIL', 'GENAP', 'ANTARA']);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            $table->unique(['year', 'term']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};
