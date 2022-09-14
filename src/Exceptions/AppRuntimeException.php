<?php
// +----------------------------------------------------------------------
// | When work is a pleasure, life is a joy!
// +----------------------------------------------------------------------
// | User: shook Liu  |  Email:24147287@qq.com  | Time: 2018/8/29/029 13:52
// +----------------------------------------------------------------------
// | TITLE: todo?
// +----------------------------------------------------------------------

namespace Liushoukun\LaravelProjectTools\Facades\Exceptions;


use RuntimeException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;


abstract class AppRuntimeException extends RuntimeException implements HttpExceptionInterface, ExceptionCodePrefixInterface
{


    protected array     $errors;
    protected int       $statusCode;
    protected array     $headers;
    protected mixed     $data;
    public static array $errorList = [];


    public function __construct(string $message = "", int $code = 0, array $errors = [], int $statusCode = 400, array $headers = [], mixed $data = null, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors     = $errors;
        $this->headers    = $headers;
        $this->statusCode = $statusCode;
    }


    public function getDefaultMessage($code, $message = '')
    {
        if (filled($message)) {
            return $message;
        }
        return self::$errorList[$code] ?? ($this->message ?? '');
    }


    public function getStatusCode() : int
    {
        return $this->statusCode;
    }


    public function getErrors() : array
    {
        return count($this->errors) > 0 ? $this->errors : [];
    }

    public function getData() : mixed
    {
        return $this->data;
    }

    public function errors() : ?array
    {
        return count($this->errors) > 0 ? $this->errors : null;
    }

    public function getHeaders() : array
    {
        return $this->headers;
    }


}
