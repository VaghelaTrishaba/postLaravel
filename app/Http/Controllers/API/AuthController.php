<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{
    public function signup(Request $request)
    {
            $validateUser = Validator::make(        //cheack data of login page 
                $request->all(),    //cheack all data
                [
                            "name"=>"required",
                            "email"=> "required|email|unique:users,email",
                            "password"=> "required",
                       ]
            );

            if ($validateUser->fails())
            {
                return response()->json(['Message'=>'Validator error','Status'=>False],401) ; 
            }
            
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json(['message'=> 'user Created','status'=>true,'user'=>$user],200) ;

    }


    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(), 
     [
                'email'    => 'required|email',
                'password' => 'required',
            ]
        );

        if ($validator->fails()) 
        {
            return response()->json([
                'message' => 'Validation failed',
                'status'  => false,
                'errors'  => $validator->errors()
                ],);
        }

        if (Auth::attempt(['email'=> $request->email,'password'=> $request->password])) 
        {

            $user = Auth::user();

            return response()->json([
                'message'    => 'User Login Successfully',
                'status'     => true,
                'token'      => $user->createToken('api token')->plainTextToken,
                'token_type' => 'bearer'
            ], 200);
        }

        return response()->json(['message' => 'Email or password not match','status'  => false],);
    }

     public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
            'status'  => true
        ]);
    }
}
?>
