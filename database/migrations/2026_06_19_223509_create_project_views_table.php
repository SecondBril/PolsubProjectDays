<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_views', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('project_id')->constrained('projects')->cascadeOnDelete();

            $table->string('visitor_hash', 64)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->text('referrer_url')->nullable();

            $table->string('country', 50)->nullable();
            $table->string('city', 100)->nullable();

            $table->timestamp('viewed_at')->nullable();

            $table->index(['project_id', 'viewed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_views');
    }
};
