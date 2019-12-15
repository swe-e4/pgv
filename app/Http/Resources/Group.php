<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Group extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'id' => $this->id,
                'adviser_id' => $this->adviser_id,
                'last_update' => $this->updated_at->diffForHumans(),
            ],
            'links' => [
                'self' => $this->path(),
            ]
        ];
    }
}
