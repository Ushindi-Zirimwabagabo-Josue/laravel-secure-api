<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PassportAuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',
        ]);

        $data['password'] = bcrypt($request->password);

        $user = User::create($data);
        
        $token = $user->createToken('LaravelPassportAuth')->accessToken;

        return response()->json(['message' => 'User successfully created', 'token'=> $token], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if(!auth()->attempt($credentials)){
            return response()->json(['message' => 'Incorrect credentials'], 401);
        }
        $token = auth()->user()->createToken('LaravelPassportAuth')->accessToken;

        return response()->json(['token'=> $token], 200);
    }

    public function userInfo() 
    {
 
        $user = auth()->user();
      
        return response()->json(['user' => $user], 200);
 
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
