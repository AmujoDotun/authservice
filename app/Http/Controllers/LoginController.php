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
    public function index(Request $request)
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



    // public function index(Request $request)
    // {
    //     $hasher = app()->make('hash');
    //     $email = $request->input('email');
    //     $password = $request->input('password');

    //     $login = User::where('email', $email)->first();

    //     if($login)
    //     {
    //         $res['success'] = false;
    //         $res['message'] = 'Your email or password incorrect';
    //         return response($res);
    //     }
    //     else{
    //         if($hasher->check($password, $login->password))
    //         {
    //             $api_token = shal(time());

    //         }
    //     }
    // }
    //  /**
    //  * @var \Tymon\JWTAuth\JWTAuth
    //  */
    // protected $jwt;

    // public function __construct(JWTAuth $jwt)
    // {
    //     $this->jwt = $jwt;
    // }

    // public function postLogin(Request $request)
    // {
    //     $this->validate($request, [
    //         'email'    => 'required|email|max:255',
    //         'password' => 'required',
    //     ]);

    //     try {

    //         if (! $token = $this->jwt->attempt($request->only('email', 'password'))) {
    //             return response()->json(['user_not_found'], 404);
    //         }

    //     } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

    //         return response()->json(['token_expired'], 500);

    //     } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

    //         return response()->json(['token_invalid'], 500);

    //     } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

    //         return response()->json(['token_absent' => $e->getMessage()], 500);

    //     }

    //     return response()->json(compact('token'));
    // }
}
