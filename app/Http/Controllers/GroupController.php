<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Resources\Group as GroupResource;
use Illuminate\Http\Request;

class GroupController extends Controller
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
            'adviser_id' => 'nullable|bail|numeric|exists:users,id',
        ]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Group::class);
        
        return GroupResource::collection(Group::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Group::class);

        $group = Group::create($this->validateData());

        return (new GroupResource($group))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        $this->authorize('view', $group);
        return new GroupResource($group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        $this->authorize('update', $group);

        $group->update($this->validateData());
        
        return (new GroupResource($group))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $this->authorize('delete', $group);
        $group->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }
}
