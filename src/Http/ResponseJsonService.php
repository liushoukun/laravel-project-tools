<?php

namespace Liushoukun\LaravelProjectTools\Http;

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
        $responseArray               = [
            'code'    => $errorCode,
            'message' => $message,
            'data'    => $data,
            'errors'  => $errors, // 错误集合
        ];
        $responseArray['request-id'] = request()->header('x-request-id');
        if (config('app.debug')) {
            $responseArray['request-info']['start-time'] = LARAVEL_START;
            $responseArray['request-info']['end-time']   = microtime(true);
            $responseArray['request-info']['time']       = bcadd(microtime(true) - LARAVEL_START, 0, 3);
            $responseArray['request-info']['start-date'] = date('Y-m-d H:i:s', LARAVEL_START);
            $responseArray['request-info']['end-date']   = date('Y-m-d H:i:s', microtime(true));
        }
        return $responseArray;

    }


}
