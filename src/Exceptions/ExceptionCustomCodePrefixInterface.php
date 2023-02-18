<?php

namespace Liushoukun\LaravelProjectTools\Exceptions;

interface ExceptionCustomCodePrefixInterface
{

    /**
     * 自定义领域错误码前缀
     * @return int
     */
    public function getDomainCode() : int;


    /**
     * 自定义服务错误码前缀
     * @return int
     */
    public function getServiceCode() : int;
}
