<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Appointment extends JsonResource
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
                'name' => $this->name,
                'start' => $this->start,
                'end' => $this->end,
                'description' => $this->description,
                'traffic_light_status' => $this->traffic_light_status,
                'rating' => $this->rating,
                'group_id' => $this->group_id,
                'group' => new Group($this->group),
                'last_update' => $this->updated_at->diffForHumans(),
            ]
        ];
    }
}
