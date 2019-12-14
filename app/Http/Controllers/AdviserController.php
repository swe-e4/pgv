<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Resources\Adviser as AdviserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AdviserController extends Controller
{
    /**
     * Return request with valid data
     *
     * @return array
     */
    private function validateData()
    {
        return request()->validate([
            'first_name' => 'required',
            'surname' => 'required',
            'email' => 'required|email:rfc,dns',
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
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
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

        $adviser = User::create(array_merge($this->requiredData(), $this->validateData()));

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
        
        return (new AdviserResource($adviser->update($this->validateData())))
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
        $adviser-destroy();

        return response([], Response::HTTP_NO_CONTENT);
    }
}
