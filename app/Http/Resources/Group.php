<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

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
        if($request->has('appointments')) {
            $appointments = Appointment::collection($this->appointments);
            $traffic_lights = array();
            $traffic_light_status_count = array('total' => 0);
            $ratings = array();
            $rating_count = array('total' => 0);

            foreach($this->appointments as $appointment) {
                $traffic_light_status_count['total'] += 1;
                if(key_exists($appointment->traffic_light_status, $traffic_light_status_count)) {
                    $traffic_light_status_count[$appointment->traffic_light_status] += 1;
                } else {
                    array_push($traffic_lights, $appointment->traffic_light_status);
                    $traffic_light_status_count[$appointment->traffic_light_status] = 1;
                }

                
                $rating_count['total'] += 1;
                if(key_exists($appointment->rating, $rating_count)) {
                    $rating_count[$appointment->rating] += 1;
                } else {
                    array_push($ratings, $appointment->rating);
                    $rating_count[$appointment->rating] = 1;
                }
            }
        }
        $next_appointment = null;
        if($this->appointments && $request->has('overview')) {
            $next_appointment_db = $this->appointments()->whereRaw('NOW() <= start')->orderBy('start', 'asc')->first();
            $next_appointment = new Appointment($next_appointment_db);
        }
        return array_merge_recursive(
            [
                'data' => [
                    'id' => $this->id,
                    'name' => $this->name,
                    'adviser_id' => $this->adviser_id,
                    'adviser' => new Adviser($this->adviser),
                    'last_update' => $this->updated_at->diffForHumans(),
                ],
                'links' => [
                    'self' => $this->path(),
                ]
            ],
            ($request->has('overview') ? [
                'data' => [
                    'next_appointment' => $next_appointment,
                ]
            ] : []),
            ($request->has('students') ? [
                'data' => [
                    'students' => Student::collection($this->students),
                ]
            ] : []), 
            ($request->has('appointments') ? [
                'data' => [
                    'appointments' => $appointments,
                    'traffic_lights' => $traffic_lights,
                    'traffic_light_status_count' => $traffic_light_status_count,
                    'rating_count' => $rating_count,
                    'ratings' => $ratings,
                ]
            ] : [] )
        );
    }
}
