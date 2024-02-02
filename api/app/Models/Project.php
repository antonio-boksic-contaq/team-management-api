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
}
