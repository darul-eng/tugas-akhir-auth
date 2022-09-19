<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use App\Models\UserToken;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

final class Authentication
{
    public function login($_, array $args)
    {

        $user = User::where('email', $args['email'])->first();

        if (!$user || !Hash::check($args['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($args['email'])->plainTextToken;

        DB::table('user_tokens')->insert([
            'user_id' => $user->id,
            'token' => $token,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        // dd($user->id);
        // UserToken::create([
        //     'user_id' => $user->id,
        //     'token' => $token,
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);

        return $token;
    }

    public function verify($_, array $args)
    {
        // $token = UserToken::where('token', $args['token'])->first();
        $token = DB::table('user_tokens')->where('token', $args['token'])->first();
        if ($token != null) {
            return true;
        }else{
            return false;
        }
    }

    public function logout($_, array $args)
    {
        // $user = UserToken::where('token', $args['token'])->with('user')->first();
        $user = DB::table('user_tokens')->where('token', $args['token'])->with('user')->first();
        if ($user) {
            $token = UserToken::find($user->id);
            $token->delete();
            return $user->user;
        } else {
            return null;
        }
    }
}
