<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof JWTException) return (new JWTExceptionHandler())->render($e);
        if ($e instanceof ModelNotFoundException) return (new ModelNotFoundHandler())->render($e);

        $rendered = parent::render($request, $e);

        $trace = (env('APP_DEBUG', false))
            ? ['file' => $e->getFile(), 'line' => $e->getLine(), 'trace' => $e->getTrace()]
            : [];

        $message = !empty($e->getMessage())
            ? $e->getMessage()
            : ($e instanceof NotFoundHttpException ? __('errors.invalid_address') : '');

        return response()->json([
            'code'      => $rendered->getStatusCode(),
            'status'    => 'error',
            'message'   => $message,
            'data'      => $trace
        ], $rendered->getStatusCode() );
    }
}
