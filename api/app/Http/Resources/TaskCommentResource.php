<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class TaskCommentResource extends JsonResource
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
            'content' => $this->content,
            'task_id' => $this->task_id,
            'user' => $this->user()->select('id','name','lastname')->first(),
            //created_at è un timestamp, io nel frontend mi mando i datetime quindi lo converto
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}