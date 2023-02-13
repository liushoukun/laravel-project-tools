<?php

namespace Liushoukun\LaravelProjectTools\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Liushoukun\LaravelProjectTools\Contracts\RequestIDBuildInterface;

class RequestIDBuildService implements RequestIDBuildInterface
{
    public function build(Request $request) : string
    {
        return (string)(date('Ymd') . '-' . date('His') . '-' . Str::uuid());
    }


}
