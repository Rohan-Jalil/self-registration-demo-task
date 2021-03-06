<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

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
     * @param Throwable $exception
     * @return void
     *
     * @throws Exception|Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param Throwable $exception
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ValidationException) {
            return response()->json([
                'message' => trans('exception.validation'),
                'errors'  => $exception->errors()
            ], 422);
        }

        if ($exception instanceof ErrorException) {
            return response()->json([
                'status' => trans('exception.failure'),
                'message' => trans($exception->getName(), $exception->getParams()),
                'data' => []
            ], $exception->getStatusCode());
        }

        if ($exception instanceof MessageException) {
            return response()->json([
                'status' => trans('exception.failure'),
                'message' => $exception->getMsg(),
                'data' => []
            ], $exception->getStatusCode());
        }

        return $this->prepareJsonResponse($request, $exception);
    }
}
