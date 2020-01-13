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
        return array_merge_recursive (
            [
                'data' => [
                    'id' => $this->id,
                    'name' => $this->name,
                    'start' => $this->start,
                    'end' => $this->end,
                    'description' => $this->description,
                    'traffic_light_status' => $this->traffic_light_status,
                    'rating' => $this->rating,
                    'last_update' => $this->updated_at->diffForHumans(),
                ]
            ], 
            (!$request->has('appointments') ? [
                'data' => [
                    'group_id' => $this->group_id,
                    'group' => new Group($this->group),
                ]
            ] : [] )
            );
    }
}
