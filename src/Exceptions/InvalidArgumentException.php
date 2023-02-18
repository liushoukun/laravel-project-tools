<?php

namespace Liushoukun\LaravelProjectTools\Exceptions;

class InvalidArgumentException extends AppRuntimeException
{
    /**
     * 自定义领域错误码前缀
     * @return int
     */
    public function getDomainCode() : int
    {
        return 10;
    }

    /**
     * 自定义服务错误码前缀
     * @return int
     */
    public function getServiceCode() : int
    {
        return 10;
    }


}
