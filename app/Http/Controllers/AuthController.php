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
        $data = $request->all();
        dd($data);
    }

    public function register(Request $request)
    {
        $this->repository->register($request->all());
    }

    public function logout(Request $request)
    {
        $data = $request->all();
        dd($data);
    }

    public function me(Request $request)
    {
        $data = $request->all();
        dd($data);
    }
}
