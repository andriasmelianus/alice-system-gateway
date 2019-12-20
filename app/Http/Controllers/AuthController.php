<?php

namespace App\Http\Controllers;

use Validator;
use App\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    private $request;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * @return Array
     */
    public function jwt(User $user, $remember=FALSE){
        $expirationTime = 60 * 60 * 12;
        if($remember){
            $expirationTime = 60 * 60 * 24 * 365 * 5;
        }

        $payload = [
            'iss' => 'lumen-jwt',
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + $expirationTime,
        ];

        return JWT::encode($payload, env('JWT_SECRET'));
    }

    /**
     * Proses autentikasi user
     *
     * @return void
     */
    public function authenticate(){
        $this->validate($this->request, [
            'username' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('username', $this->request->input('username'))->first();
        if(!$user){
            return response()->json([
                'error' => [
                    'username' => 'Username does not exist'
                ]
            ], 400);
        }

        if(Hash::check($this->request->input('password'), $user->password)){
            return response()->json([
                'token' => $this->jwt($user, $this->request->input('remember'))
            ], 200);
        }

        return response()->json([
            'error' => [
                'username' => 'Username or password invalid'
            ]
        ],400);
    }

    public function user(Request $req){
        return $req->auth;
    }
}
