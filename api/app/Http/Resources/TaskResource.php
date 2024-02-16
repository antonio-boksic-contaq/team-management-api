<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'notes' => $this->notes,
            'deadline_date' => $this->deadline_date,
            'start_date' => $this->start_date,
            'finish_date' => $this->finish_date,
            'expected_hours' => $this->expected_hours,
            'task_status' => $this->taskStatus,
            'task_priority' => $this->taskPriority,
            'project' => new ProjectResource($this->project),
            'user' => new UserResource($this->user),
        ];
    }
}