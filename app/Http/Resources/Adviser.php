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
        $groups_string = '';
        $groups_string_id = '';
        foreach($this->groups as $group) {
            $groups_string .= $group->name.';';
            $groups_string_id .= $group->id.';';
        }

        return [
            'data' => [
                'id' => $this->id,
                'first_name' => $this->first_name,
                'surname' => $this->surname,
                'full_name' =>  $this->surname.', '.$this->first_name,
                'email' => $this->email,
                'groups_string' => $groups_string,
                'groups_string_id' => $groups_string_id,
                'groups' => $this->groups,
                'last_update' => $this->updated_at->diffForHumans(),
            ],
            'links' => [
                'self' => $this->path(),
            ]
        ];
    }
}
