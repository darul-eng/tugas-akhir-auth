<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            $error = 'The provided credentials are incorrect.';

            return handleError('Unprocessable Content', ['error' => $error], 422);
        }

        $token = $user->createToken($request->email)->plainTextToken;

        DB::table('user_tokens')->insert([
            'user_id' => $user->id,
            'token' => $token,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        // UserToken::create([
        //     'user_id' => $user->id,
        //     'token' => $token,
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);

        return handleResponse(['token' => $token], 'success');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        // $token = UserToken::where('token', $request->token)->first();
        $token = DB::table('user_tokens')->where('token', $request->token)->first();
        if ($token != null) {
            $datas = ['verify' => true];
            $code = 200;
        }else{
            $datas = ['verify' => false];
            $code = 401;
        }

        return response()->json($datas, $code);
    }

    public function logout(Request $request)
    {
        $request->validate([
            'token' => 'required'
        ]);

        // $user = UserToken::where('token', $request->token)->with('user')->first();
        $user = DB::table('user_tokens')->where('token', $request->token)->with('user')->first();

        if ($user) {
            $token = UserToken::find($user->id);
            $token->delete();
            return $user->user;
        } else {
            return null;
        }
    }
}
