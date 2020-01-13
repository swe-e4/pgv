<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class ChangePasswordController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'passwordNew' => 'required|same:passwordNewRepeat',
            'passwordNewRepeat' => 'required',
        ]);

        if(Hash::check($request->input('password'), auth()->user()->password)) {

            if($request->input('password') != $request->input('passwordNew')) {
                User::find(auth()->user()->id)->update(['password'=> Hash::make($request->input('passwordNew'))]);
                return 'true';
            } else {
                return 'same_as_old';
            }
        } else {
            return 'wrong_pw';
        }
    }
}
