<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Adviser extends JsonResource
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
                'first_name' => $this->first_name,
                'surname' => $this->surname,
                'email' => $this->email,
                'groups' => $this->groups,
                'last_update' => $this->updated_at->diffForHumans(),
            ],
            'links' => [
                'self' => $this->path(),
            ]
        ];
    }
}
