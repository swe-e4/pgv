<?php

namespace App\Http\Controllers;

use App\User;
use App\Group;
use App\Http\Resources\Adviser as AdviserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class AdviserController extends Controller
{
    /**
     * Return request with valid data
     *
     * @return array
     */
    private function validateData($adviser = NULL)
    {
        return request()->validate([
            'first_name' => 'required',
            'surname' => 'required',
            'email' => 'bail|required|email:rfc,dns|unique:users,email'.(isset($adviser) ? ','.$adviser->id : ''),
            //'password' => 'required',
        ]);
    }

    /**
     * Return required data
     *
     * @return array
     */
    private function requiredData()
    {
        return [
            'api_token' => Str::random(60),
            'role_id' => 2,
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        
        return AdviserResource::collection(User::where('role_id', 2)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $password = Str::random(12);

        $adviser = User::create(array_merge(
            $this->requiredData(),
            $this->validateData(),
            ['password' => Hash::make($password)]
        ));

        if($request->input('groups')) {
            $groups = Group::find($request->input('groups'));
            $adviser->groups()->saveMany($groups);
        }

        Mail::to($adviser->email)->send(new WelcomeMail($adviser, $password));

        return (new AdviserResource($adviser))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $adviser
     * @return \Illuminate\Http\Response
     */
    public function show(User $adviser)
    {
        $this->authorize('view', $adviser);
        return new AdviserResource($adviser);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $adviser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $adviser)
    {
        $this->authorize('update', $adviser);

        $adviser->update($this->validateData($adviser));
        if($request->input('groups') || $request->input('groupUpdate')) {
            foreach($adviser->groups as $group) {
                if(!$request->input('groups') || !in_array($group->id, $request->input('groups'))) {
                    $group->adviser_id = NULL;
                    $group->save();
                }
            }
            if($request->input('groups')) {
                $groups = Group::find($request->input('groups'));
                $adviser->groups()->saveMany($groups);
            }
        }

        return (new AdviserResource($adviser->fresh()))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $adviser
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $adviser)
    {
        $this->authorize('delete', $adviser);
        $adviser->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }
}
