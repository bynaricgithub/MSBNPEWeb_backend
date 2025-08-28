<?php

namespace App\Services\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class Authentication
{
    public function adminLogin($email, $password, $request)
    {
        try {
            $credentials = ['email' => $email, 'password' => $password];

            if (! Auth::attempt($credentials)) {
                return response()->json([
                    'message' => 'wrong email and password',
                ], 401);
            }

            $userData = User::where('email', $email)->first();

            if ($userData->role == 1) {
                $user = $request->user();
                $tokenResult = $user->createToken($user->name);
                $token = $tokenResult->token;

                // if ($request->remember_me) {
                //     // $token->expires_at = Carbon::now()->addWeeks(1);
                //     $token->expires_at =  Carbon::now()->addSeconds(30);
                // }
                $token->expires_at = Carbon::now()->addSeconds(Config::get('constants.TOKEN_EXPIRY_TIME'));

                $token->save();

                $token_expiry_time = Config::get('constants.TOKEN_EXPIRY_TIME');
                $refresh_token_expiry_time = Config::get('constants.REFRESH_TOKEN_EXPIRY_TIME');

                $cookie = cookie('token', $tokenResult->accessToken, $token_expiry_time, null, null, false, true);

                return response()->json([
                    'status' => 'Success',
                    'message' => 'Login successful.',
                    'data' => [
                        'access_token' => $tokenResult->accessToken,
                        'token_type' => 'Bearer',
                        'name' => $userData->name,
                        'email' => $userData->email,
                        'role' => $userData->role,

                        'expires_at' => Carbon::parse(
                            $tokenResult->token->expires_at
                        )->toDateTimeString(),
                    ],

                ], 200)->cookie($cookie);
            }
        } catch (\Exception $e) {

            return response()->json([
                'status' => 'failure',
                'message' => 'Problem in login. Error:'.$e->getMessage(),
                'data' => [],
            ], 500);
        }
    }

    public function adminRegistration($name, $email, $password, $role, $request)
    {
        try {

            $credentials = ['name' => $name, 'email' => $email, 'password' => $password, 'role' => $role];

            User::create($credentials);

            echo 'ok...';

            // Save the user to the database

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'failure',
                'message' => 'Problem. Error:'.$e->getMessage(),
                'data' => [],
            ], 500);
        }
    }

    public function logout($request)
    {

        $request->user()->token()->revoke();

        return response()->json([
            'status' => 'success',
            'message' => 'User logged out successfully...',
        ], 200);
    }

    public function whoAmI()
    {
        $AuthUser = Auth::user();
        // $userWiseRole = self::userWiseRole(Auth::user()->role_id);

        return response()->json([
            'status' => 'success',
            'message' => 'Authorized User...',
            'data' => en(json_encode($AuthUser)),
            'role' => en(json_encode($AuthUser->role)),
            // 'userWiseRole' => $userWiseRole == "" ? "not found!" : en(json_encode($userWiseRole)),
        ], 200);
    }
}
