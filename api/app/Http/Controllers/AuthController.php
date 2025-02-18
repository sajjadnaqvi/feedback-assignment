<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function __construct(private UserRepository $repository) {
        // $this->var = $var;
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->input();
        $user = $this->repository->store($data);

        if ($user && auth()->attempt($data)) {
            $access_token = auth()->user()->createToken('authToken')->accessToken;
            return response()->success("User Register Successfully", compact('user', 'access_token'));
        }
    }

    public function login(LoginRequest $request)
    {
        $loginData = $request->input();

        if (!auth()->attempt($loginData)) {
            return response()->error('The user credentials were incorrect.', 422);
            // return response(['message' => 'The user credentials were incorrect.'], 422);
        }

        $access_token = auth()->user()->createToken('authToken')->accessToken;

        return response()->success("User Login Successfully", compact('access_token'));
    }

    public function logout(Request $request)
    {
        $user = auth()->user();
        $user->token()->revoke();

        return response()->success("Logout Successfully");
    }
}
