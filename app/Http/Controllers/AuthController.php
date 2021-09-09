<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\AuthRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $repository;

    public function __construct(AuthRepository $repository)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->repository = $repository;
    }

    public function login(Request $request)
    {
        return $this->repository->login($request->only(['email', 'password']));
    }

    public function register(Request $request)
    {
        return $this->repository->register($request->only(['name', 'email', 'password']));
    }

    public function logout(Request $request)
    {
        return $this->repository->logout();
    }

    public function me(Request $request)
    {
        return $this->repository->me();
    }
}
