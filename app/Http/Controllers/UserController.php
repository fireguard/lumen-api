<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
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

    public function store(UserService $service, UserRequest $request)
    {
        $user = $service->create($request);
        if (!is_null($user)) {
            return $this->responseSuccess('Usuário cadastrado com sucesso', 200, [
                'data' => [ 'id' => $user->id ]
            ]);
        }
        return $this->responseError('Erro ao salvar o usuário', 500);
    }

    public function update(UserService $service, UserRequest $request, $id)
    {

        $user = User::findOrFail($id);
        if (!is_null($service->update($request, $user))) {
            return $this->responseSuccess('Usuário atualizado com sucesso', 200, [
                'data' => [ 'id' => $user->id ]
            ]);
        }
        return $this->responseError('Erro ao salvar o usuário', 500);
    }

    public function delete(UserService $service, JWTAuth $auth, $id)
    {
        if ($service->delete($auth, $id)) {
            return $this->responseSuccess('Usuário excluído com sucesso', 200, [
                'data' => [ 'id' => $id ]
            ]);
        }
        return $this->responseError('Erro ao excluir o usuário solicitado', 500);
    }

}
