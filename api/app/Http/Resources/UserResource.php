<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        //dd($this);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'lastname' => $this->lastname,
            'email'=> $this->email,
            'gender'=> $this->gender,
            //'team_id'=> $this->team_id,
            'team' => new TeamResource($this->team),
            'projects' => ProjectResource::collection($this->whenLoaded('projects')),
            'role' => $request->user()->getRoleNames()[0],
            //'role' => $this->roles()->first()->name,
            //'permissions' => Role::findByName($this->roles->first()->name, 'api')->permissions()->where('software','hr')->pluck('name'),
            //'permissions' => Role::findByName($this->roles->first()->name)->permissions()->pluck('name'),
            'permissions' => $request->user()->getPermissionsViaRoles()->pluck('name'),
            // questo mi serve per passare il LabelField al v-select nel frontend per poter vedere nome e cognome nella select.
            "complete_name" => $this->lastname . " " . $this->name
        ];
    }
}