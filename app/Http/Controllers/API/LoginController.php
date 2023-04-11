<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!Hash::check($request->password,  $user->password)) {
            return 'cannot password like this';
        }

        if ($user->status !== 'admin' && $user->status !== 'writer') {
            return 'cannot password like thissssss';
        } else {
            $token = $user->createToken($user->name);
            return response()->json(['token' => $token->plainTextToken, 'user' => $user]);
        }
    }
    public function logout(request $request)
    {
        $user = User::where('email', $request->email)->first();
        return  $user->tokens()->delete();
    }
}
