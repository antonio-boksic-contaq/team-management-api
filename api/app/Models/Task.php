<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function taskPriority() {
        return $this->belongsTo(TaskPriority::class);
    }

    public function taskStatus() {
        return $this->belongsTo(TaskStatus::class);
    }
    
    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function taskAttachments() {
        return $this->hasMany(TaskAttachment::class);
    }

    public function taskComments() {
        return $this->hasMany(TaskComment::class);
    }

    //TODO per ora ho copiaincollato quello che ho nella resource, dopo vediamo di sistemarla e capire come usarla nella resource
    public function getProgress() {
        $tasks_of_this_project = $this->tasks;
        //dd($tasks_of_this_project);

        $score_of_completed_tasks = 0;
        $total_score_of_tasks = 0;

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

        $project_progress = ($score_of_completed_tasks / $total_score_of_tasks) * 100;
    }
}