<?php

namespace Liushoukun\LaravelProjectTools\Contracts;

interface User
{
    /**
     * 用户类型
     * @return string|int
     */
    public function getUserType() : string|int;

    /**
     * 获取用户ID
     * @return int|string
     */
    public function getUID() : string|int;


    /**
     * 所属人
     * @return User|null
     */
    public function getOwner() : User|null;


}
