<?php

namespace Liushoukun\LaravelProjectTools\Services;

use Closure;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Liushoukun\LaravelProjectTools\Contracts\RequestIDBuildInterface;
use Symfony\Component\HttpFoundation\Response;


class RequestIDService
{

    /**
     * 字段名称
     * @var string
     */
    protected static string $fieldName             = 'X-Request-Id';
    public RequestIDBuildInterface $requestIDBuild;
    protected string        $requestID;
    protected bool          $injectionResponseJson = true;

    public function __construct(RequestIDBuildInterface $requestIDBuild)
    {
        $this->requestIDBuild        = $requestIDBuild;
        $this->injectionResponseJson = (bool)config('laravel-project-tools.request_id.with_response_body');

    }

    /**
     * @return void
     */
    public static function boot() : void
    {
        Request::macro('getRequestID', function () {
            return $this->header(RequestIDService::$fieldName);
        });
    }

    /**
     * 中间件处理
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function middlewareHandle(Request $request, Closure $next) : Response
    {

        return $this->buildID($request)
                    ->withLogContext()
                    ->withResponse($next($request));
    }

    protected function withResponse(Response $response) : Response
    {
        return $this->withResponseHeader($this->withResponseBody($response));
    }

    protected function withResponseHeader($response)
    {

        $response->header(self::$fieldName, $this->requestID);
        return $response;
    }

    protected function withResponseBody($response)
    {
        if ($this->injectionResponseJson && $response instanceof JsonResponse) {
            $data                               = $response->getData(true);
            $data[Str::lower(self::$fieldName)] = $this->requestID;
            $response->setData($data);
        }
        return $response;
    }

    /**
     * 绑定日志
     * @return $this
     */
    protected function withLogContext() : self
    {
        Log::withContext([ self::$fieldName => $this->requestID ]);
        return $this;
    }

    protected function buildID(Request $request) : RequestIDService
    {
        $this->requestID = $this->requestIDBuild->build($request);
        return $this;
    }


}
