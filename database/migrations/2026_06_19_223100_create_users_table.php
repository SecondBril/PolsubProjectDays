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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nim_nidn', 20)->unique()->nullable();
            $table->string('name', 150);
            $table->string('email', 150)->unique();
            $table->string('password')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('avatar')->nullable();

            $table->enum('role', ['mahasiswa', 'dosen', 'admin', 'superadmin'])->default('mahasiswa');
            $table->boolean('is_active')->default(true);
            $table->timestamp('email_verified_at')->nullable();

            // Metadata Mahasiswa
            $table->foreignUuid('program_id')->nullable()->constrained('programs')->nullOnDelete();
            $table->integer('cohort')->nullable(); // Tahun Angkatan
            $table->integer('current_semester')->nullable();

            // Metadata Dosen
            $table->text('expertise')->nullable();
            $table->string('academic_rank', 50)->nullable();

            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['role', 'is_active']);
            $table->index(['program_id', 'cohort']);
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
