<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Milestone extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return  [
            'data' => [
                'id' => $this->id,
                'name' => $this->name,
                'deadline' => $this->deadline,
                'last_update' => $this->updated_at->diffForHumans(),
            ]
        ];
    }
}
