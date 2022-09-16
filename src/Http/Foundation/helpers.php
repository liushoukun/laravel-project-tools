<?php

use Liushoukun\LaravelProjectTools\Http\Requests\ClientInfoRequestAdapter;

if (!function_exists('tools_client_info')) {
    /**
     * @param \Illuminate\Http\Request|null $request
     * @return ClientInfoRequestAdapter
     */
    function tools_client_info(?\Illuminate\Http\Request $request = null) : ClientInfoRequestAdapter
    {
        return ClientInfoRequestAdapter::make($request);
    }
}
