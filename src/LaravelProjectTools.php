<?php

namespace Liushoukun\LaravelProjectTools;

use Liushoukun\LaravelProjectTools\Contracts\ClientInfo;

class LaravelProjectTools
{

    /**
     * @param array $parameters
     * @return ClientInfo|null
     */
    public function getClientInfo(array $parameters = []) : ?ClientInfo
    {
        return collect($parameters)->first(function ($parameter) {
            if ($parameter instanceof ClientInfo) {
                return true;
            } else {
                return false;
            }
        });
    }
}
