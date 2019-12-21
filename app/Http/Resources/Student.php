<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Student extends JsonResource
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
                'surname' => $this->surname,
                'first_name' => $this->first_name,
                'email' => $this->email,
                'student_number' => $this->student_number,
                'group' => new Group($this->group),
                'last_update' => $this->updated_at->diffForHumans(),
            ]
        ];
    }
}
