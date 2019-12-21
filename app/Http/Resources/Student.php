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
        return array_merge_recursive (
            [
                'data' => [
                    'id' => $this->id,
                    'surname' => $this->surname,
                    'first_name' => $this->first_name,
                    'email' => $this->email,
                    'student_number' => $this->student_number,
                    'last_update' => $this->updated_at->diffForHumans(),
                ]
            ], 
            (!$request->has('students') ? [
                'data' => [
                    'group' => new Group($this->group),
                ]
            ] : [] )
            );
    }
}
