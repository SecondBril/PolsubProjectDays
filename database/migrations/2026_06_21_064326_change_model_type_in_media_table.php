<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('media', function (Blueprint $table) {
            // 1. Lepas indeks polimorfik bawaan agar kolom tidak terkunci
            $table->dropIndex(['model_type', 'model_id']);
        });

        Schema::table('media', function (Blueprint $table) {
            // 2. Ubah tipe kolom mendukung UUID string
            $table->string('model_id', 36)->change();

            // 3. Pasang kembali indeksnya agar query pencarian gambar tetap cepat
            $table->index(['model_type', 'model_id']);
        });
    }

    public function down(): void
    {
        Schema::table('media', function (Blueprint $table) {
            $table->dropIndex(['model_type', 'model_id']);
        });

        Schema::table('media', function (Blueprint $table) {
            $table->unsignedBigInteger('model_id')->change();
            $table->index(['model_type', 'model_id']);
        });
    }
};
