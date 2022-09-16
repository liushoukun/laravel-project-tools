<?php

namespace Liushoukun\LaravelProjectTools\Contracts;

/**
 * 操作人
 */
interface Operator
{
    /**
     * 用户类型
     * @return string|int
     */
    public function userType() : string|int;

    /**
     * 用户ID
     * @return int|string
     */
    public function uid() : string|int;

    /**
     * 昵称
     * @return string|null
     */
    public function nickname() : ?string;


    /**
     * 用户头像
     * @return string|null
     */
    public function avatar() : ?string;


}
