<?php

namespace Liushoukun\LaravelProjectTools\Http;

use Illuminate\Http\JsonResponse;

trait ResponseJson
{

    /**
     * 成功响应
     * @param mixed|null $data
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function success(mixed $data = null, string $message = 'success', int $statusCode = 200) : JsonResponse
    {
        return self::responseJson(0, $message, $statusCode, $data, []);
    }

    /**
     * 失败响应
     * @param string $message
     * @param int $code
     * @param int $statusCode
     * @param array $errors
     * @param mixed $data
     * @return JsonResponse
     */
    public function error(string $message = 'error', int $code = 1, int $statusCode = 400, array $errors = [], mixed $data = null) : JsonResponse
    {
        return self::responseJson($code, $message, $statusCode, $data, $errors);
    }

    /**
     * 构件构件响应
     * @param int $code
     * @param string $message
     * @param int $status_code
     * @param mixed|null $data
     * @param array $errors
     * @return JsonResponse
     */
    protected static function responseJson(int $code, string $message, int $status_code, mixed $data = null, array $errors = []) : JsonResponse
    {
        $data = [
            'code'        => $code,
            'message'     => $message,
            'data'        => $data,
            'time'        => microtime(true) - LARAVEL_START,
            'date'        => date('Y-m-d H:i:s'),
            'errors'      => $errors,
            'status_code' => $status_code,
        ];
        return response()->json($data, $status_code);
    }


}
