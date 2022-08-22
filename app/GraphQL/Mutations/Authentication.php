<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use App\Models\UserToken;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

final class Authentication
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    // public function __invoke($_, array $args)
    // {
    //     // TODO implement the resolver
    // }
    public function login($_, array $args)
    {

        $user = User::where('email', $args['email'])->first();

        if (!$user || !Hash::check($args['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($args['email'])->plainTextToken;

        // dd($user->id);
        UserToken::create([
            'user_id' => $user->id,
            'token' => $token,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return $token;
    }

    public function verify($_, array $args)
    {
        $token = UserToken::where('token', $args['token'])->first();
        // dd($token->user_id);
        // dd(UserToken::where('token', "7IrhZUt5kwE2EBRuGpqqZgnh7KixHMKClNpuYjQCPRGsSM5gm6Y5rD4KEcD7noAwDkahIi499ROPal2Lq6KObqFUUkrpZfMbbxoLrn7Tx7R0Xw0F4xMYU2UHPksnBtGUN89tY4o4xxsvYGNQ5l1LLp16iu1kwXa6B51fqvipvZKxv3TnKdTcPEL2oC7Tqm6G7uXDSBPK7oZLySv3QFde4ANBLAT1BV9TObA9b"));
        if ($token != null) {
            return true;
        }else{
            return false;
        }
    }
}
