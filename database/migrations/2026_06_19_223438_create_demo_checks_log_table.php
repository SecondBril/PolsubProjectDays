<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demo_checks_log', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('project_id')->constrained('projects')->cascadeOnDelete();

            $table->integer('status_code')->nullable();
            $table->integer('response_time_ms')->nullable();
            $table->string('status', 20);
            $table->text('error_message')->nullable();

            $table->timestamp('checked_at')->nullable();

            $table->index(['project_id', 'checked_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demo_checks_log');
    }
};
