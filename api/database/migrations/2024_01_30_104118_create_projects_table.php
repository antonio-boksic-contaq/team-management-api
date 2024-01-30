<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('notes')->nullable();
            $table->foreignId('project_priority_id')->references('id')->on('project_priorities');
            // da caprie come gestire progress_status dato che dovrebbe essere una formula: 
            // expected hours di task associati al progetto completati /  expected hours di tutti task associati al progetto
            $table->integer('progress_status')->unsigned()->default(0);
            $table->dateTime('deadline_date');
            $table->dateTime('end_date')->nullable();
            $table->foreignId('project_status_id')->default(1)->references('id')->on('project_statuses');
            $table->foreignId('project_applicant_id')->nullable()->references('id')->on('project_applicants');
            $table->foreignId('project_category_id')->references('id')->on('project_categories');
            $table->softDeletes();
            $table->timestamps();
        });
        // Aggiungo vincolo di intervallo da 0 a 100 a progress_status
        DB::statement('ALTER TABLE projects ADD CONSTRAINT progress_status_range CHECK (progress_status >= 0 AND progress_status <= 100)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
