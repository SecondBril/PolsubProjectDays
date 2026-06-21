<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('title', 200);
            $table->string('slug', 200)->unique();
            $table->text('description');
            $table->string('short_description', 255)->nullable();

            // Relasi Akademik & Filtrasi
            $table->foreignUuid('program_id')->constrained('programs')->restrictOnDelete();
            $table->foreignUuid('category_id')->constrained('categories')->restrictOnDelete();
            $table->foreignUuid('course_class_id')->constrained('course_classes')->restrictOnDelete(); // Link ke MK, Semester, Dosen
            $table->integer('cohort'); // Tahun Angkatan Mahasiswa

            // Link & Demo
            $table->string('demo_url', 500)->nullable();
            $table->string('repository_url', 500)->nullable();
            $table->string('documentation_url', 500)->nullable();

            // Status Workflow
            $table->enum('status', ['draft', 'pending', 'revision', 'rejected', 'published', 'archived'])->default('draft');

            // Live Demo Monitoring
            $table->enum('demo_status', ['active', 'offline', 'error', 'unknown'])->default('unknown');
            $table->timestamp('last_demo_check_at')->nullable();
            $table->integer('last_demo_status_code')->nullable();

            // Featured
            $table->boolean('is_featured')->default(false);
            $table->integer('featured_order')->default(0);

            // Statistik
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('demo_clicks_count')->default(0);

            // SEO
            $table->string('meta_title', 200)->nullable();
            $table->string('meta_description', 300)->nullable();

            // Ownership & Approval
            $table->foreignUuid('team_lead_id')->constrained('users')->restrictOnDelete(); // Ketua Tim
            $table->foreignUuid('reviewer_id')->nullable()->constrained('users')->nullOnDelete(); // Admin Verifikator
            $table->timestamp('published_at')->nullable();
            $table->text('rejected_reason')->nullable();

            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexing (Sesuai PRD 14.2)
            $table->index(['status', 'program_id', 'category_id', 'cohort'], 'idx_projects_filter');
            $table->index(['status', 'created_at'], 'idx_projects_listing');
            $table->index(['status', 'views_count'], 'idx_projects_popular');
            $table->index(['is_featured', 'featured_order'], 'idx_projects_featured');

            // Full-Text Search MySQL (InnoDB)
            $table->fullText(['title', 'short_description', 'description']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
