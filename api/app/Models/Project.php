<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function projectApplicant() {
        return $this->belongsTo(ProjectApplicant::class);
    }

    public function projectCategory() {
        return $this->belongsTo(ProjectCategory::class);
    }

    public function projectPriority() {
        return $this->belongsTo(ProjectPriority::class);
    }

    public function projectStatus() {
        return $this->belongsTo(ProjectStatus::class);
    }

    public function users() {
        return $this->belongsToMany(User::class)->withPivot('supervisor');
    }

    public function projectAttachments() {
        return $this->hasMany(ProjectAttachment::class);
    }

    public function tasks() {
        return $this->hasMany(Task::class);
    }

    public function progress() {
        $tasks_of_this_project = $this->tasks;
        //dd($tasks_of_this_project);

        $score_of_completed_tasks = 0;
        $total_score_of_tasks = 0;
        $project_progress = 0;

        foreach ($tasks_of_this_project as $task ) {
            //se task ha status completato, aggiungo score sia a ore totali che completate
            if ($task->task_status_id === 3) {
                    $total_score_of_tasks += $task->time_difficulty_score;
                    $score_of_completed_tasks += $task->time_difficulty_score;
            // altrimenti aggiungo lo score solo a ore totali
            } else {
                    $total_score_of_tasks += $task->time_difficulty_score;
            }

        }

        //round mi serve per arrotondare e trasformare in intero
        if ($total_score_of_tasks != 0) {
            $project_progress = round(($score_of_completed_tasks / $total_score_of_tasks) * 100);
        }

        return $project_progress;
    }

    
}