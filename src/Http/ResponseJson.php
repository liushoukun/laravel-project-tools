<?php

namespace Liushoukun\LaravelProjectTools\Http;

use Illuminate\Http\JsonResponse;

trait ResponseJson
{

    /**
     * 成功响应
     * @param mixed|null $data
     * @param string $message
     * @return JsonResponse
     */
    public static function success(mixed $data = null, string $message = 'ok') : JsonResponse
    {
        return ResponseJsonService::success($data, $message);
    }


    /**
     * 失败响应
     * @param string $message
     * @param int|string $code
     * @param int $statusCode
     * @param array $errors
     * @param mixed $data
     * @return JsonResponse
     */
    public static function error(string $message = 'error', int|string $code = 1, int $statusCode = 400, array $errors = [], mixed $data) : JsonResponse
    {
        return ResponseJsonService::error($message, $code, $statusCode, $errors, $data);
    }


}
