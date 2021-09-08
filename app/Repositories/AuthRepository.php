<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthRepository
{
    public $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function register(array $data)
    {
        try {
            $this->model->create($data);
            return response()->json(['status' => 'created', 'data' => $data]);
        } catch (\Throwable $th) {
            return response()->json();
        }
    }

    public function login(array $data)
    {
        $credentials = $data;

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

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
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
