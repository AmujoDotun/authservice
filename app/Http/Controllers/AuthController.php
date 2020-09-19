<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $hasher = app()->make('hash');
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $hasher->make($request->input('password'));
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        $res['success'] = true;
        $res['message'] = 'Success register!';
        $res['data'] = $user;
        return response($res);
    }
    /**
     * Get user by id
     *
     * URL /user/{id}
     */
    public function get_user(Request $request, $id)
    {
        $user = User::where('id', $id)->get();
        if ($user) {
              $res['success'] = true;
              $res['message'] = $user;

              return response($res);
        }else{
          $res['success'] = false;
          $res['message'] = 'Cannot find user!';

          return response($res);
        }
    }
    // public function register(Request $request)
    // {
    //     //validate incoming request 
    //     $this->validate($request, [
    //         'name' => 'required|string',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required',
    //     ]);

    //     try {

    //         $user = new User;
    //         $user->name = $request->input('name');
    //         $user->email = $request->input('email');
    //         $plainPassword = $request->input('password');
    //         $user->password = app('hash')->make($plainPassword);

    //         $user->save();

    //         //return successful response
    //         return response()->json(['user' => $user, 'message' => 'You have succefully created your account'], 201);

    //     } catch (\Exception $e) {
    //         //return error message
    //         return response()->json(['message' => 'Your Registration Failed!'], 409);
    //     }

    // }

}
