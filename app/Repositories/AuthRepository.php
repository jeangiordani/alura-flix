<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthRepository
{
    public $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function register(array $data)
    {
        $validated = Validator::make(
            $data,
            [
                'name' => 'required|string|min:3|',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
            ]
        );

        if ($validated->fails()) {
            return response()->json([
                'status' => 'fail',
                'errors' => $validated->errors()->messages()
            ], 422);
        } else {
            $data = [
                "name" => $data['name'],
                "password" => bcrypt($data['password']),
                "email" => $data['email']
            ];
        }

        return response()->json(['status' => 'success', 'data' => $data], 201);
    }

    public function login(array $data)
    {

        $credentials = Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($credentials->fails()) {
            return response()->json([
                'status' => 'fail',
                'errors' => $credentials->errors()->messages()
            ], 422);
        }

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
