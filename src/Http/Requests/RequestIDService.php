<?php

namespace Liushoukun\LaravelProjectTools\Http\Requests;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class RequestIDService
{

    public static function providerBoot() : void
    {
        self::setFieldName(config('laravel-project-tools.request_id.id_name'));
        Request::macro('getRequestID', function () {
            return RequestID::getRequestID($this);
        });
    }

    protected static string $fieldName = 'x-request-id';

    /**
     * @return string
     */
    public static function getFieldName() : string
    {
        return self::$fieldName;
    }

    /**
     * @param string $fieldName
     */
    public static function setFieldName(string $fieldName) : void
    {
        self::$fieldName = $fieldName;
    }


    /**
     * 中间件处理
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public static function middlewareHandle(Request $request, Closure $next)
    {
        try {
            $requestID = self::setRequestID($request);
        } catch (BindingResolutionException $e) {
            $requestID = '';
        }
        self::withLogContext($requestID);
        return self::withResponse($next($request), $requestID);

    }

    protected static function withLogContext($requestID) : void
    {
        if (config('laravel-project-tools.request_id.with_log_context')) {
            Log::withContext([ self::getFieldName() => $requestID ]);
        }
    }

    protected static function withResponse($response, $requestID)
    {
        $response = self::withResponseBody($response, $requestID);
        return self::withResponseHeader($response, $requestID);

    }

    protected static function withResponseBody($response, $requestID)
    {
        if ($response instanceof JsonResponse && config('laravel-project-tools.request_id.with_response_body')) {
            $data = $response->getData(true);
            if (self::getResoponseBodyWraper()) {
                $data[self::getResoponseBodyWraper()][self::getFieldName()] = $requestID;
            } else {
                $data[self::getFieldName()] = $requestID;
            }
            $response->setData($data);
        }
        return $response;
    }

    protected static function getResoponseBodyWraper()
    {
        return config('laravel-project-tools.request_id.body_warp', 'tools');

    }

    protected static function withResponseHeader($response, $requestID)
    {
        if (config('laravel-project-tools.request_id.with_response_headers')) {
            $response->header(self::getFieldName(), $requestID);
        }
        return $response;
    }

    /**
     * 设置请求ID
     * @param Request|null $request
     * @return string
     * @throws BindingResolutionException
     */
    public static function setRequestID(?Request $request = null) : string
    {
        $requestID = self::getRequestID($request);
        if (!$requestID) {
            $request   = $request ?: Container::getInstance()->make('request');
            $requestID = self::generateRequestID($request);
            $request->headers->set(self::getFieldName(), $requestID);

            // 注入宏
            $request->getRequestID = function () {
                return RequestID::getRequestID($this);
            };
        }
        return $requestID;
    }

    /**
     * 获取请求ID
     * @param Request|null $request
     * @return string
     * @throws BindingResolutionException
     */
    public static function getRequestID(?Request $request = null) : string
    {
        $request = $request ?: Container::getInstance()->make('request');
        return (string)($request->header(self::getFieldName()) ?? '');
    }

    /**
     * 生成请求ID
     * @param Request $request
     * @return string
     */
    public static function generateRequestID(Request $request) : string
    {
        return (string)(date('YmdHis') . '-' . Str::uuid());
    }
}
