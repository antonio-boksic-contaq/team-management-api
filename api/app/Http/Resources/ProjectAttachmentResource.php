<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\ProjectResource;

class ProjectAttachmentResource extends JsonResource
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
            //'name' => $this->name,
            //'description' => $this->description,
            'original_name' => $this->original_name,
            'file_path' => $this->file_path,
            'project' => new ProjectResource($this->project),
            'user' => new UserResource($this->user),
        ];
    }
}