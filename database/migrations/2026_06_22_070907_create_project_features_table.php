<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_features', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('project_id')->constrained('projects')->cascadeOnDelete();

            $table->string('name'); // Nama Fitur (misal: "Real-time Chat")
            $table->string('icon', 100)->nullable(); // Class Font Awesome (misal: "fa-solid fa-comments")
            $table->integer('order')->default(0); // Untuk mengatur urutan tampilan

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_features');
    }
};
