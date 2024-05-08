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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('notes')->nullable();        
            // $table->dateTime('assignment_date'); // non sono sicuro che serva, si potrebbe usare 

            $table->dateTime('start_date')->nullable();
            $table->dateTime('deadline_date')->nullable();
            $table->dateTime('end_date')->nullable();
            // $table->integer('expected_hours');
            $table->integer('time_difficulty_score');
            $table->foreignId('task_status_id')->references('id')->on('task_statuses');
            $table->foreignId('task_priority_id')->references('id')->on('task_priorities');
            $table->foreignId('project_id')->references('id')->on('projects');
            //$table->foreignId('user_id')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });
        // // Aggiungo vincolo di intervallo da 0 a 100 a time_difficulty_score
        DB::statement('ALTER TABLE tasks ADD CONSTRAINT time_difficulty_score_range CHECK (time_difficulty_score >= 1 AND time_difficulty_score <= 10)');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};