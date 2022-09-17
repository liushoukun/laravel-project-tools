<?php

namespace Liushoukun\LaravelProjectTools\Http;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\This;
use Throwable;

class ResponseJsonService
{


    /**
     * The "data" wrapper that should be applied.
     *
     * @var string|null
     */
    public static $wrap = 'data';

    /**
     * Set the string that should wrap the outer-most resource array.
     *
     * @param string $value
     * @return void
     */
    public static function wrap(string $value)
    {
        static::$wrap = $value;
    }

    public static function wrapper()
    {
        return self::$wrap;
    }

    /**
     * Disable wrapping of the outer-most resource array.
     *
     * @return void
     */
    public static function withoutWrapping()
    {
        static::$wrap = null;
    }


    public static function responseJson(mixed $data, string $message, int|string $code, array $errors = []) : JsonResponse
    {
        return new JsonResponse(self::wrapData($data, $message, $code, $errors));
    }

    public static function wrapData(mixed $data, string $message, int|string $code, array $errors = []) : array
    {

        if (self::wrapper()) {
            $data = [ self::$wrap => $data ];
        }
        return array_merge_recursive($data, self::additional($code, $message, $errors));

    }


    public static function additional(int|string $code = 0, string $message = '', array|null $errors = []) : array
    {
        $data            = [];
        $data['code']    = $code;
        $data['message'] = $message;
        $data['errors']  = $errors;
        return $data;
    }


}
