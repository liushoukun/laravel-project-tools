<?php

namespace Liushoukun\LaravelProjectTools\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class SqlLogService
{


    public static function boot() : void
    {
        if (!config('app.debug')) {
            return;
        }
        $channel = config('laravel-project-tools.sql-log.channel', null);
        DB::listen(static function ($query) use ($channel) {
            try {
                $sql = str_replace("?", "'%s'", $query->sql);
                $log = vsprintf($sql, $query->bindings ?? []);
            } catch (Throwable $e) {
                $log = $query->sql;
            }
            Log::channel($channel)->debug('sql:' . $log . ' time:' . $query->time);
        });

    }
}
