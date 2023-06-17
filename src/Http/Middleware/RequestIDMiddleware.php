<?php

namespace Liushoukun\LaravelProjectTools\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Liushoukun\LaravelProjectTools\Http\Requests\RequestIDService;

class RequestIDMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        return RequestIDService::middlewareHandle($request, $next);
    }


}
