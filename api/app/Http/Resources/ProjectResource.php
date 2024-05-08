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
            //'progress' => $this->progress === null ? 0 : $this->progress,
            "start_date" => $this->start_date,
            "deadline_date" => $this->deadline_date,
            'end_date' => $this->end_date,
            'project_status' => new ProjectStatusResource($this->projectStatus), 
            'project_applicant' => new ProjectApplicantResource($this->projectApplicant), 
            'project_category' => new ProjectCategoryResource($this->projectCategory),
            // all_users, e in particolare la resource applicata a questo, mi serve per
            // poter passare complete_name all'attributo label di vue-select nel form di task per associare utenti e task.
            'all_users' => UserResource::collection($this->users),
            'users' => $this->users()->wherePivot('supervisor', 0)->get(),
            "supervisors" =>  $this->users()->wherePivot('supervisor', 1)->get(),
            "deleted_at" => $this->deleted_at,
            "files" => ProjectAttachmentResource::collection($this->whenLoaded('projectAttachments')),
            //"files" => $this->whenLoaded('projectAttachments')
            "progress"  => $this->progress()
        ];
    }
}