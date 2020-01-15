<?php

namespace App\Http\Controllers;

use App\Appointment;
use Illuminate\Http\Request;
use App\Http\Resources\Appointment as AppointmentResource;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use App\User;
use App\Student;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Return request with valid data
     *
     * @return array
     */
    private function validateData()
    {
        return request()->validate([
            'name' => 'required',
            'start' => 'nullable',
            'end' => 'nullable',
            'group_id' => 'nullable|bail|numeric|exists:groups,id',
            'description' => 'nullable',
            'traffic_light_status' => 'nullable|in:red,yellow,green',
            'rating' => 'nullable|in:+,0,-',
        ]);
    }
    private function validateDataTest()
    {
        return request()->validate([
            'description' => 'nullable',
            'traffic_light_status' => 'nullable|in:red,yellow,green',
            'rating' => 'nullable|in:+,0,-',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Appointment::class);


        if($request->has('week')) {
            $user = User::find(Auth::id());
            $appointments = Appointment::whereBetween('start', [Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->orderBy('start', 'asc')->get();
            $week = array(
                '1' => [],
                '2' => [],
                '3' => [],
                '4' => [],
                '5' => [],
                '6' => [],
                '7' => [],
            );
            foreach($appointments as $appointment) {
                if($user->role_id == 1 || $appointment->group->adviser_id == $user->id) {
                    if(date('w', strtotime($appointment->start)) > 0) {
                        array_push($week[date('w', strtotime($appointment->start))], new AppointmentResource($appointment));
                    }
                }
            }
            $maxRows = 0;
            foreach($week as $day) {
                if(count($day) > $maxRows) {
                    $maxRows = count($day);
                }
            }
            $result = array();
            for($i = 0; $i < $maxRows; $i++) {
                $result[$i] = array(
                    '1' => [],
                    '2' => [],
                    '3' => [],
                    '4' => [],
                    '5' => [],
                    '6' => [],
                    '7' => [],
                );
                foreach($week as $key => $day) {
                    if(count($day) > $i) {
                        $result[$i][$key] = $day[$i];
                    } else {
                        $result[$i][$key] = false;
                    }
                }
            }
            return $result;
        } else {
            $user = User::find(Auth::id());
            $appointments = Appointment::all();
            if($user->role_id == 2) {
                $tmp = array();
                foreach($appointments as $appointment) {
                    if($appointment->group->adviser_id == $user->id) {
                        array_push($tmp, new AppointmentResource($appointment));
                    }
                }
                $appointments = array('data' => $tmp);
            } else {
                $appointments = AppointmentResource::collection($appointments);
            }
            return $appointments;
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Appointment::class);

        $appointment = Appointment::create($this->validateData());

        return (new AppointmentResource($appointment))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        $this->authorize('view', $appointment);
        return new AppointmentResource($appointment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        $this->authorize('update', $appointment);

        $appointment->update($this->validateDataTest());
        
        if($request->has('studentList') || $request->has('updateStudents')) {
            if($request->input('studentList')) {
                $list = $request->input('studentList');
            } else {
                $list = [];
            }
            $studentList = Student::find($list);
            $appointment->students()->sync($studentList);
        }

        return (new AppointmentResource($appointment))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        $this->authorize('delete', $appointment);
        $appointment->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }
}
