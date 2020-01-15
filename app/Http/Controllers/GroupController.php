<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Resources\Group as GroupResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\User;
use App\Milestone;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        $user = User::find(Auth::id());

        if($user->role_id == 2) {
            return GroupResource::collection(Group::where('adviser_id', $user->id)->get());
        } else {
            return GroupResource::collection(Group::all());
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

        if($request->has('milestoneID') && $request->has('doneOn') &&
            $milestone = Milestone::find($request->input('milestoneID'))) {

            $doneOn = Carbon::parse($request->input('doneOn'))->format('Y-m-d');

            if($group_milestone = \DB::table('group_milestone')->where('group_id', $group->id)->where('milestone_id', $milestone->id)->first()) {
                $affected = \DB::table('group_milestone')->where('id', $group_milestone->id)->update(['done_on' => $doneOn]);
            } else {
                \DB::table('group_milestone')->insert(
                    [
                        'group_id' => $group->id,
                        'milestone_id' => $milestone->id,
                        'done_on' => $doneOn
                    ]
                );

            }
            return response('', Response::HTTP_OK);

        } else {
            $group->update($this->validateData());
            
            return (new GroupResource($group))
                ->response()
                ->setStatusCode(Response::HTTP_OK);
        }
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
