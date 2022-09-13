<?php

namespace Liushoukun\LaravelProjectTools\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RequestID
{
    public function handle(Request $request, Closure $next)
    {
        $requestID = self::buildRequestID($request);
        $request->headers->set('x-request-id', $requestID);

        Log::withContext([
                             'request-id' => $requestID
                         ]);
        $response = $next($request);

        return $response->header('x-request-id', $requestID);
    }

    public static function buildRequestID(Request $request) : string
    {
        return (string)(date('YmdHis') . '-' . Str::uuid());
    }
}
