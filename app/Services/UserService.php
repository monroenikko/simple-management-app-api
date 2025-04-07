<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Interfaces\UserInterface;
use App\Traits\ResponseApi;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserService
{
    use ResponseApi;

    protected $repository;

    public function __construct(UserInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $user = $this->repository->store($request);
            $res = new UserResource($user);
            $token = $user->createToken('auth_token')->plainTextToken;
            if (! $res) {
                return $this->error('User not created', Response::HTTP_BAD_REQUEST);
            }
            $data = [
                'user' => $res,
                'token' => $token,
                'token_type' => 'Bearer',
            ];
            DB::commit();

            return $this->success(
                'User Successfully Created.',
                Response::HTTP_CREATED,
                $data
            );
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->error($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
