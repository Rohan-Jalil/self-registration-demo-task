<?php

namespace App\Http\Transformers\Responses;

use Illuminate\Http\JsonResponse;

/**
 * Trait ApiResponder
 * @package App\Http\Transformers\Responses
 */
trait ApiResponder
{
    /**
     * @param $data
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function success($data, $message = '', $statusCode = 200): JsonResponse
    {
        if ($message === '') {
            $message = trans('messages.success');
        }
        $response = array_merge([
            'message' => $message,
        ], $data->toArray());

        return response()->json($response, $statusCode);
    }

    /**
     * @param $error
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function failure($error, $message = '', $statusCode = 422): JsonResponse
    {
        if ($message === '') {
            $message = trans('exception.failure');
        }
        return response()->json([
            'message' => $message,
            'error' => $error
        ], $statusCode);
    }
}
