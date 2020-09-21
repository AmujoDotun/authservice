<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{


    public function register(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        try {

            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);

            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'message' => 'You have succefully created your account'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Your Registration Failed!'], 409);
        }

    }

}
