<?php

namespace App\Repositories;

use App\Interfaces\AuthInterface;
use App\Models\User;

class AuthRepository implements AuthInterface
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function login($request)
    {
        return $this->model->whereEmail($request['email'])->firstOrFail();
    }

    public function user($request)
    {
        return $request->user();
    }

    public function logout($request)
    {
        return $this->user($request)->currentAccessToken()->delete();
    }
}
