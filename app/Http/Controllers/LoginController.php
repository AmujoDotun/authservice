<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class LoginController extends Controller
{

     /**
     * Index login controller
     *
     * When user success login will retrive callback as api_token
     */





    public function login(Request $request)
    {
        $hasher = app()->make('hash');
 
        $email = $request->input('email');
        $password = $request->input('password');
        $login = User::where('email', $email)->first();
 
        if ( ! $login) {
            $res['success'] = false;
            $res['message'] = 'Your email or password incorrect!';
            return response($res);
        } else {
            if ($hasher->check($password, $login->password)) {
                $api_token = sha1(time());
                $create_token = User::where('id', $login->id)->update(['api_token' => $api_token]);
                if ($create_token) {
                    $res['success'] = true;
                    $res['api_token'] = $api_token;
                    $res['message'] = $login;
                    return response($res);
                }
            } else {
                $res['success'] = true;
                $res['message'] = 'You email or password incorrect!';
                return response($res);
            }
        }
    }



    // Planned to make use of passport to maintain the token

    // public function login(Request $request) {

    //     $this->validate($request, [
    //         'email' => 'required',
    //         'password' => 'required'
    //     ]);
        
        
    //     $email = $request->input('email');
    //     $password = $request->input('password');

    //     $user = User::where('email', $email)->first();

    //     if($user === null) {
    //         return response()->json(['error' => true, 'message' =>  "user not found!"], 401);
    //     }

    //     //get user's token
    //     $token = $user->api_token;

    //     if (Hash::check($password, $user->password)) { 

    //         return response()->json(['data' => [ 'success' => true, 'user' => $user, 'token' => 'Bearer ' . $token]], 200);

    //     }
    //     return response()->json(['error' => true, 'message' => "Invalid Credential"], 401);
        
    // }

   
}
