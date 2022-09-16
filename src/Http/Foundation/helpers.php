<?php

use Liushoukun\LaravelProjectTools\Contracts\ClientInfo;
use Liushoukun\LaravelProjectTools\Http\Requests\ClientInfoRequestAdapter;

if (!function_exists('tools_client_info_adapter')) {
    /**
     * @param \Illuminate\Http\Request|null $request
     * @return ClientInfoRequestAdapter
     */
    function tools_client_info_adapter(?\Illuminate\Http\Request $request = null) : ClientInfoRequestAdapter
    {
        return ClientInfoRequestAdapter::make($request);
    }
}


if (!function_exists('tools_get_client_info')) {

    /**
     * @param array $parameters
     * @return ClientInfo|null
     */
    function tools_get_client_info(array $parameters = []) : ?ClientInfo
    {
        return \Liushoukun\LaravelProjectTools\Facades\LaravelProjectTools::getClientInfo($parameters);
    }
}
