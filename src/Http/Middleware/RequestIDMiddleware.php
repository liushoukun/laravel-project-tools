<?php

namespace Liushoukun\LaravelProjectTools\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Liushoukun\LaravelProjectTools\Services\RequestIDService;
use Symfony\Component\HttpFoundation\Response;

class RequestIDMiddleware
{
    public function handle(Request $request, Closure $next) : Response
    {
        return app(RequestIDService::class)->middlewareHandle($request, $next);
    }


}
