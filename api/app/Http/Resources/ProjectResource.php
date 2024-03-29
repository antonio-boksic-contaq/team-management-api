<?php

namespace App\Http\Resources;

use App\Models\ProjectPriority;
use Carbon\Carbon;
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
            'progress' => $this->progress === null ? 0 : $this->progress,
            "deadline_date" => $this->deadline_date,
            //Carbon::createFromFormat('d/m/Y', $request->stockupdate)->format('Y-m-d')
            'end_date' => $this->end_date,
            'project_status' => new ProjectStatusResource($this->projectStatus), 
            'project_applicant' => new ProjectApplicantResource($this->projectApplicant), 
            'project_category' => new ProjectCategoryResource($this->projectCategory),
            'users' => $this->users()->wherePivot('supervisor', 0)->get(),
            "supervisors" =>  $this->users()->wherePivot('supervisor', 1)->get(),
            "deleted_at" => $this->deleted_at,
            "files" => ProjectAttachmentResource::collection($this->whenLoaded('projectAttachments')),
            //"files" => $this->whenLoaded('projectAttachments')
        ];
    }
}