<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\ProjectResource;

class TaskAttachmentResource extends JsonResource
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
            'original_name' => $this->original_name,
            'file_path' => $this->file_path,
            'project' => new ProjectResource($this->project),
            'user' => $this->user()->select('id','name','lastname')->get(),
            //'users' => $this->user
        ];
    }
}