<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class userController extends Controller
{
    /**
     * Create New User .
     */
    public function signup(Request $request)
    {
        $validRequest = Validator::make($request->all() , [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);
        
        if ($validRequest->fails()) {
            return response(['message' => 'string' , 
            'errors' => 
                ['name' => '[`string`]' , 
                 'email' => '[`string`]',
                 'password' => '[`string`]' , 
                 'password_confirmation' => '[`string`]' ]
            ] , 422);
        }


        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->password = Hash::make($request->password);

        $user->save();

        return response()->json([
            'message' => 'User Created',
            'user' => $user
        ], 200);
    }
    



    /**
     * Login To Existing User . 
     */
    public function signin(Request $request)
    {
        $validRequest = Validator::make($request->all() , [
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        if ($validRequest->fails()){
            return response(['message' => 'string' , 
            'errors' => 
                ['email' => '[`string`]',
                 'password' => '[`string`]']
            ] , 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'invalid credentials.'] , 401);
        }
        
    }


}
