<?php

namespace Liushoukun\LaravelProjectTools\Contracts;

use Illuminate\Http\Request;

interface RequestIDBuildInterface
{

    /**
     * 生成请求ID
     * @param Request $request
     * @return string
     */
    public function build(Request $request) : string;

}
