<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    public function team() {
        return $this->belongsTo(Team::class);
    }

    public function projects() {
        return $this->belongsToMany(Project::class)->withPivot('supervisor');
    }

    public function projectAttachments() {
        return $this->hasMany(ProjectAttachment::class);
    }

    public function tasks() {
        return $this->belongsToMany(Task::class);
    }

    public function taskAttachments() {
        return $this->hasMany(TaskAttachment::class);
    }

    public function taskComments() {
        return $this->hasMany(TaskComment::class);
    }
}