<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

trait HandleResponseApi
{
    public static function responseSuccess(mixed $data = [], string $message = 'success', int $code = 0): JsonResponse
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ]);
    }

    public static function responseError(
        string $message = 'error',
        mixed $data = [],
        int $httpStatusCode = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR,
        int $code = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
    ): JsonResponse {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'error' => $data,
        ], $httpStatusCode);
    }
}
