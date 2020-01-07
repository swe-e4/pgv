<?php

namespace App\Http\Controllers;

use App\Appointment;
use Illuminate\Http\Request;
use App\Http\Resources\Appointment as AppointmentResource;
use Symfony\Component\HttpFoundation\Response;

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
            'start' => 'nullable|date',
            'end' => 'nullable|date',
            'group_id' => 'nullable|bail|numeric|exists:groups,id',
            'description' => 'required',
            'traffic_light_status' => 'required|in:red,yellow,green',
            'rating' => '|in:+,0,-',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Appointment::class);
        
        return AppointmentResource::collection(Appointment::all());
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

        $appointment->update($this->validateData());
        
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
