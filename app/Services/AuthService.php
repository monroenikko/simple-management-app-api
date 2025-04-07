<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Interfaces\AuthInterface;
use App\Traits\ResponseApi;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    use ResponseApi;

    protected $repository;

    public function __construct(AuthInterface $repository)
    {
        $this->repository = $repository;
    }

    public function login($request)
    {
        try {
            $creds = ['email' => $request['email'], 'password' => $request['password']];
            if (! Auth::attempt($creds)) {
                return $this->error('These credentials do not match our records.', Response::HTTP_UNAUTHORIZED);
            }
            $user = $this->repository->login($request);
            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->success(
                'You are successfully login. Welcome back '.$user->full_name.'!',
                Response::HTTP_OK,
                [
                    'user' => $user,
                    'token' => $token,
                    'token_type' => 'Bearer',
                ],
            );
        } catch (Exception $e) {
            return $this->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function user($request)
    {
        $user = new UserResource($request->user());

        return $this->success('Successfully fetch', Response::HTTP_OK, ['user' => $user]);
    }

    public function logout($request)
    {
        try {
            $this->repository->logout($request);

            return $this->success('Logged out successfully', Response::HTTP_OK, []);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
