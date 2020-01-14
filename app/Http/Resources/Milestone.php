<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Group as GroupModel;

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
        $group = null;
        if($request->has('group_id') && $group = GroupModel::find($request->input('group_id'))) {
            $done_on = \DB::table('group_milestone')->where('group_id', $group->id)->where('milestone_id', $this->id)->first();
        }
        return array_merge_recursive([
                'data' => [
                    'id' => $this->id,
                    'name' => $this->name,
                    'deadline' => $this->deadline,
                    'last_update' => $this->updated_at->diffForHumans(),
                ]
            ],
            ( $group != null ?
            [
                'data' => [
                    'done_on' => ($done_on ? $done_on->done_on : null)
                ]
            ] : [])
        );
    }
}
