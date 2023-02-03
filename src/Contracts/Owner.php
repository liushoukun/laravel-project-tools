<?php

namespace Liushoukun\LaravelProjectTools\Contracts;

/**
 * 所属
 */
interface Owner
{
    public function getOwner() : User;
}
