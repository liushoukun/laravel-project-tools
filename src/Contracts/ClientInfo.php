<?php

namespace Liushoukun\LaravelProjectTools\Contracts;

use Illuminate\Contracts\Support\Arrayable;

/**
 * 客户端信息
 */
interface ClientInfo
{

    /**
     * 客户端IP
     * @return string|null
     */
    public function ip() : ?string;

    /**
     * User Agent
     * @return string|null
     */
    public function userAgent() : ?string;

    /**
     * 平台
     * @return string|null
     */
    public function platform() : ?string;

    /**
     * 设备
     * @return string|null
     */
    public function device() : ?string;

    /**
     * 浏览器
     * @return string|null
     */
    public function browser() : ?string;


}
