<?php

namespace Liushoukun\LaravelProjectTools\Http;

use Throwable;

class ResponseJsonService
{


    /**
     *  响应Json 数组
     * @param int|string $errorCode
     * @param string $message
     * @param mixed $data
     * @param array|null $errors
     * @return array
     */
    public static function responseToArray(int|string $errorCode = 0, string $message = '', mixed $data, ?array $errors) : array
    {
        // 是否开启debug
        $responseArray = [
            'code'    => $errorCode,
            'message' => $message,
            'data'    => $data,
            'errors'  => $errors, // 错误集合
        ];
        try {
            $responseArray['request']['request-id'] = request()->header('x-request-id');
        } catch (Throwable $throwable) {
            $responseArray['request-id'] = null;
        }
        return $responseArray;

    }


}
