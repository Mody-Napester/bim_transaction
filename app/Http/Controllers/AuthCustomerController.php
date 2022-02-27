<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function Symfony\Component\Console\Style\success;

class AuthCustomerController extends Controller
{
    /**
     * Login
     */
    public function login(Request $request)
    {
        // Check user exists
        $user = User::where('email', $request->email)->first();
        if(!$user){
            return response([
                'status' => false,
                'message' => 'User not found'
            ]);
        }

        // Auth user
        if(auth()->attempt(['email' => $request->email, 'password' => $request->password])){
            $abilities = explode(',', $user->user_type->permissions);

            $token = auth()->user()->createToken('app-token', $abilities)->plainTextToken;

            return response([
                'status' => true,
                'message' => 'User found',
                'token' => $token,
                'user' => new UserResource($user)
            ], 200);
        }else{
            return response([
                'status' => false,
                'message' => 'Credentials (Email or Password) Not Correct'
            ]);
        }
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        $user = $request->user();

        if($user){
            if($user->tokens()){
                $user->tokens()->delete();
                return response([
                    'status' => true,
                    'message' => 'User logged out'
                ], 200);
            }else{
                return response([
                    'status' => false,
                    'message' => 'User not authed'
                ]);
            }
        }else{
            return response([
                'status' => false,
                'message' => 'User not found'
            ]);
        }
    }
}
