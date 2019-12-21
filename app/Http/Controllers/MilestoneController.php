<?php

namespace App\Http\Controllers;

use App\Milestone;
use App\Http\Resources\Milestone as MilestoneResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MilestoneController extends Controller
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
           'deadline' => 'required|date',
       ]);
   }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Milestone::class);
        
        return MilestoneResource::collection(Milestone::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Milestone::class);

        $milestone = Milestone::create($this->validateData());

        return (new MilestoneResource($milestone))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Milestone  $milestone
     * @return \Illuminate\Http\Response
     */
    public function show(Milestone $milestone)
    {
        $this->authorize('view', $milestone);
        return new MilestoneResource($milestone);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Milestone  $milestone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Milestone $milestone)
    {
        $this->authorize('update', $milestone);

        $milestone->update($this->validateData());
        
        return (new MilestoneResource($milestone))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Milestone  $milestone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Milestone $milestone)
    {
        $this->authorize('delete', $milestone);
        $milestone->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }
}
