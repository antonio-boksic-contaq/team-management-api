<?php

namespace App\Http\Resources;

use App\Models\ProjectPriority;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'notes'=> $this->notes,
            'project_priority' => new ProjectPriorityResource($this->projectPriority),
            'progress_status' => $this->project_status,
            'deadline_date' => $this->deadline_date,
            'end_date' => $this->end_date,
            'project_status' => new ProjectStatusResource($this->projectStatus), 
            'project_applicant' => new ProjectApplicantResource($this->projectApplicant), 
            'project_category' => new ProjectCategoryResource($this->projectCategory), 
        ];
    }
}
