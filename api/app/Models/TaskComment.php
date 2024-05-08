<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskComment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user() {
        return $this->BelongsTo(User::class);
    }

    public function task() {
        return $this->BelongsTo(Task::class);
    }
}