<?php

namespace Liushoukun\LaravelProjectTools\Exceptions;

use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Liushoukun\LaravelProjectTools\Http\ResponseJsonService;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Create a new exception handler instance.
     *
     * @param Container $container
     * @return void
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->register();
        $this->ignore(AppRuntimeException::class);
    }


    protected function invalidJson($request, ValidationException $exception) : JsonResponse
    {
        return response()->json($this->convertExceptionToArray($exception), $exception->status);
    }

    /**
     * Convert the given exception to an array.
     *
     * @param Throwable $e
     * @return array
     */
    protected function convertExceptionToArray(Throwable $e) : array
    {
        // 如果是业务异常
        $data    = [];
        $errors  = [];
        $message = $this->isHttpException($e) ? $e->getMessage() : 'Server Error';
        if (config('app.debug')) {
            $message = $e->getMessage();
        }
        $code = $e->getCode();
        if ($e instanceof AppRuntimeException) {
            $message = $e->getMessage();
            $errors  = $e->getErrors();
            $data    = $e->getData();
        }
        if ($e instanceof ValidationException) {
            $message = Arr::get(Arr::first(array_values($e->errors())), 0) ?? $e->getMessage();
            $errors  = $e->errors();
            $code    = (string)config('laravel-project-tools.exception.common_code',9999999);
        }
        $responseArray = ResponseJsonService::responseToArray($code, $message, $data, $errors);
        if (config('app.debug')) {
            $responseArray['exception']['exception'] = get_class($e);
            $responseArray['exception']['file']      = $e->getFile();
            $responseArray['exception']['line']      = $e->getLine();
//            $responseArray['exception']['previous']  = $e->getPrevious()?$this->convertExceptionToArray($e->getPrevious()):null;
            $responseArray['exception']['trace'] = collect($e->getTrace())->map(fn($trace) => Arr::except($trace, [ 'args' ]))->all();
        }
        return $responseArray;
    }


}
