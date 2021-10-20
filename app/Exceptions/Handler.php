<?php

namespace App\Exceptions;

use App\Tools\Tool;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json([
            'code' => Tool::code('unauthenticated'),
            'msg'  => Tool::message('unauthenticated'),
            ], 401);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param Exception $exception
     * @return JsonResponse
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof AbstractException) {
            return $exception->render();
        }

        if ($exception instanceof ValidationException) {
            return response()->json([
                'code' => -1,
                'msg'  => $exception->validator->errors()->first(),
            ]);
        }

        if ($exception instanceof QueryException) {
            app('log')->error("数据库异常:" . $exception->getMessage());
            return response()->json([
                'code' => -2,
                'msg'  => "服务器开了小差",
            ]);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'code' => -2,
                'msg'  => "请求方式错误",
            ]);
        }

        if ($exception instanceof \Throwable || $exception instanceof Exception) {
            return response()->json([
                'code' => -500,
                'msg'  => $exception->getMessage(),
            ]);
        }
        return parent::render($request, $exception);
    }
}
