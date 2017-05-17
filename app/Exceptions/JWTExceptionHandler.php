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

        return response()->json([
            'code'      => $e->getCode(),
            'status'    => 'error',
            'message'   => __('errors.jwt.invalid_auth'),
            'data' => [
                'id'        => 'AuthException',
            ]
        ], $e->getCode());
    }

    /**
     * @param TokenInvalidException $e
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    protected function tokenInvalid(TokenInvalidException $e)
    {
        return response()->json([
            'code'      => $e->getCode(),
            'status'    => 'error',
            'message'   => __('errors.jwt.invalid_credentials'),
            'data' => [
                'id'        => 'InvalidCredentials',
            ]
        ], $e->getCode() );
    }

    /**
     * @param TokenBlacklistedException $e
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    protected function tokenBackListed(TokenBlacklistedException $e)
    {
        return response()->json([
            'code'      => $e->getCode(),
            'status'    => 'error',
            'message'   => __('errors.jwt.blacklist_credentials'),
            'data' => [
                'id'        => 'BlacklistCredentials'
            ]
        ], $e->getCode() );
    }

    /**
     * @param TokenExpiredException $e
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    protected function tokenExpired(TokenExpiredException $e)
    {
        return response()->json([
            'code'      => $e->getCode(),
            'status'    => 'error',
            'message'   => __('errors.jwt.expired_credentials'),
            'data' => [
                'id'        => 'ExpiredCredentials',
            ]
        ], $e->getCode() );
    }

    /**
     * @param InvalidClaimException $e
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    protected function invalidClaim(InvalidClaimException $e)
    {
        return response()->json([
            'code'      => $e->getCode(),
            'status'    => 'error',
            'message'   => __('errors.jwt.invalid_claim'),
            'data' => [
                'id'        => 'InvalidClaim',
            ]
        ], $e->getCode() );
    }

    /**
     * @param PayloadException $e
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    protected function payload(PayloadException $e)
    {
        return response()->json([
            'code'      => $e->getCode(),
            'status'    => 'error',
            'message'   => __('errors.jwt.payload'),
            'data' => [
                'id'        => 'Payload'
            ]
        ], $e->getCode() );
    }
}
