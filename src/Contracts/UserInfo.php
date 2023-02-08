<?php

namespace Liushoukun\LaravelProjectTools\Contracts;

/**
 * 用户基本信息
 */
interface UserInfo extends User
{
    /**
     * 昵称
     * @return string|null
     */
    public function getNickname() : ?string;

    /**
     * 获取头像信息
     * @return string|null
     */
    public function getAvatar() : ?string;

}
