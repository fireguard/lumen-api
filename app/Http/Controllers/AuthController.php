<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;

    /**
     * AuthController constructor.
     * @param JWTAuth $jwt
     */
    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    /**
     * @param JWTAuth $auth
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws TokenInvalidException
     */
    public function authenticate(JWTAuth $auth, Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');

        if (!$token = $auth->attempt($credentials)) {
            throw new TokenInvalidException("As Credenciais passadas são inválidas", 404);
        }
        return $this->responseSuccess("Sucesso na autenticação", 200, [ 'data' => ['token' => $token] ] );
    }

    /**
     * @param JWTAuth $auth
     * @return \Illuminate\Http\JsonResponse
     */
    public function invalidateToken(JWTAuth $auth)
    {
        $auth->invalidate($auth->getToken());
        return $this->responseSuccess("Token invalidado com sucesso", 200);
    }

    /**
     * @param JWTAuth $auth
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshToken(JWTAuth $auth)
    {
        $token = $auth->refresh($auth->getToken());
        return $this->responseSuccess("Token renovado com sucesso", 200, [ 'data' => ['token' => $token] ]  );
    }
}
