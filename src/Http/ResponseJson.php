<?php

namespace Liushoukun\LaravelProjectTools\Http;

use Illuminate\Http\JsonResponse;

trait ResponseJson
{

    /**
     * 成功响应Json
     * @param mixed|null $data
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function successJson(mixed $data = null, string $message = 'ok', int $statusCode = 200) : JsonResponse
    {
        return self::responseJson(0, $message, $statusCode, $data, []);
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
    public static function errorJson(string $message = 'error', int|string $code = 1, int $statusCode = 400, array $errors = [], mixed $data) : JsonResponse
    {
        return self::responseJson($code, $message, $statusCode, $data, $errors);
    }

    /**
     * 构件构件响应
     * @param int $code
     * @param string $message
     * @param int $statusCode
     * @param mixed|null $data
     * @param array $errors
     * @return JsonResponse
     */
    private static function responseJson(int $code, string $message, int $statusCode, mixed $data, array $errors = []) : JsonResponse
    {

        return response()->json(ResponseJsonService::responseToArray($code, $message, $data, $errors), $statusCode);
    }


}
