<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use App\Models\LoginToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $validated = $request->validate([
            'first_name' => 'required|string|min:2|max:20',
            'last_name' => 'required|string|min:2|max:20',
            'username' => 'required|alpha|unique:auths,username|min:5|max:12',
            'password' => 'required|min:5|max:12',
        ]);

        $data = Auth::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'password' => Hash::make($validated['password'])
        ]);

        if (!$data) {
            return response()->json([
                'message' => 'invalid field'
            ]);
        }

        $token = md5($data->id);
        $ket = LoginToken::create([
            'user_id' => $data->id,
            'token' => $token
        ]);

        return response()->json([
            'data' => $ket
        ], 200);
    }


public function login(Request $request) {
    $username = $request->username;
    $password = $request->password;

    $user = Auth::where('username', $username)->first();

    if ($user && Hash::check($password, $user->password)) {
        $token = md5($user->id);

        $loginToken = LoginToken::where('user_id', $user->id)->first();

        if ($loginToken) {
            $loginToken->update(['token' => $token]);
        } else {
            $token = LoginToken::create([
                'user_id' => $user->id,
                'token' => $loginToken
            ]);
        }

        return response()->json([
            'token' => $token
        ], 200);

    }

    return response()->json([
        'message' => 'invalid login'
    ], 401);
}


    public function logout(Request $request){
        $token = $request->query('token');
        $logout = LoginToken::where(['token' => $token])->first();
        if ($logout) {
            $logout->delete();
            return response()->json([
                'message' => 'logout success'
            ], 200);
        }

        return response()->json([
            'message' => 'unauthorized user'
        ], 401);
    }
}
