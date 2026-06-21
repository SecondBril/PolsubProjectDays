<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('media', function (Blueprint $table) {
            // Mengubah tipe kolom model_id dari BIGINT menjadi VARCHAR/UUID agar mendukung UUID
            $table->string('model_id', 36)->change();
        });
    }

    public function down(): void
    {
        Schema::table('media', function (Blueprint $table) {
            // Mengembalikan ke struktur default jika di-rollback
            $table->unsignedBigInteger('model_id')->change();
        });
    }
};
