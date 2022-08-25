<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($request->email)->plainTextToken;

        UserToken::create([
            'user_id' => $user->id,
            'token' => $token,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $res = [
            'message' => 'success',
            'datas' => ['token' => $token],
        ];

        // return $res;

        return response()->json($res, 200);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        $token = UserToken::where('token', $request->token)->first();
        if ($token != null) {
            $datas = ['verify' => true];
        }else{
            $datas = ['verify' => false];
        }

        $res = [
            'message' => 'success',
            'datas' => $datas,
        ];

        return response()->json($res, 200);
    }

    public function logout(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        $user = UserToken::where('token', $request->token)->with('user')->first();

        if ($user) {
            $token = UserToken::find($user->id);
            $token->delete();
            return $user->user;
        } else {
            return null;
        }
    }
}
