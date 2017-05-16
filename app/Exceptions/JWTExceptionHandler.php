<?php
namespace App\Exceptions;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\InvalidClaimException;
use Tymon\JWTAuth\Exceptions\PayloadException;


/**
 * Class OAuthExceptionHandler
 *
 * @package App\Exceptions
 */
class JWTExceptionHandler
{

    /**
     * @param JWTException $e
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function render(JWTException $e)
    {

        if ($e instanceof TokenBlacklistedException) {

            return $this->tokenBackListed($e);

        } else if ($e instanceof TokenExpiredException) {

            return $this->tokenExpired($e);

        } else if ($e instanceof InvalidClaimException) {

            return $this->invalidClaim($e);

        } else if ($e instanceof PayloadException) {

            return $this->payload($e);

        } else if ($e instanceof TokenInvalidException) {

            return $this->tokenInvalid($e);
        }

        return response([
            'code'      => $e->getCode(),
            'status'    => 'error',
            'message'   => 'Não foi possível concluir a autenticação',
            'data' => [
                'id'        => 'AuthException',
                'title'     => 'Falha na autenticação',
            ]
        ], $e->getCode());
    }

    /**
     * @param TokenInvalidException $e
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    protected function tokenInvalid(TokenInvalidException $e)
    {
        return response([
            'code'      => $e->getCode(),
            'status'    => 'error',
            'message'   => 'As credenciais passadas são inválidas',
            'data' => [
                'id'        => 'InvalidCredentials',
                'title'     => 'Credenciais Inválidas',
            ]
        ], $e->getCode() );
    }

    /**
     * @param TokenBlacklistedException $e
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    protected function tokenBackListed(TokenBlacklistedException $e)
    {
        return response([
            'code'      => $e->getCode(),
            'status'    => 'error',
            'message'   => 'As credenciais passadas se encontram em nossa lista de bloqueio',
            'data' => [
                'id'        => 'BlacklistCredentials',
                'title'     => 'Credenciais Bloqueadas',
            ]
        ], $e->getCode() );
    }

    /**
     * @param TokenExpiredException $e
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    protected function tokenExpired(TokenExpiredException $e)
    {
        return response([
            'code'      => $e->getCode(),
            'status'    => 'error',
            'message'   => 'As credenciais passadas não são mais válidas',
            'data' => [
                'id'        => 'ExpiredCredentials',
                'title'     => 'Credenciais estão expiradas',
            ]
        ], $e->getCode() );
    }

    /**
     * @param InvalidClaimException $e
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    protected function invalidClaim(InvalidClaimException $e)
    {
        return response([
            'code'      => $e->getCode(),
            'status'    => 'error',
            'message'   => 'The claim is invalid in some way',
            'data' => [
                'id'        => 'InvalidClaim',
                'title'     => 'Invalid Claim',
            ]
        ], $e->getCode() );
    }

    /**
     * @param PayloadException $e
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    protected function payload(PayloadException $e)
    {
        return response([
            'code'      => $e->getCode(),
            'status'    => 'error',
            'message'   => 'An error was generated in the authentication process',
            'data' => [
                'id'        => 'Payload',
                'title'     => 'Payload'
            ]
        ], $e->getCode() );
    }
}
