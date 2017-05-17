<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Transformers\UserTransformer;
use Tymon\JWTAuth\JWTAuth;


class UserController extends Controller
{
    public function index(UserTransformer $transformer)
    {
        $users = User::paginate(10);
        return $this->responseSuccess(null, 200, ['data' => $users], $transformer);
    }

    public function show(UserTransformer $transformer, $userId)
    {
        $user = User::findOrFail($userId);
        return $this->responseSuccess(null, 200, ['data' => $user], $transformer);
    }

    public function profile(UserTransformer $transformer, JWTAuth $auth)
    {
        return $this->responseSuccess(null, 200, ['data' => $auth->user()], $transformer);
    }

}
