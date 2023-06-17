<?php

return [
    //异常配置
    'exception'  => [
        'common_code' => 9999999,// 通用错误码
    ],


    // 日志服务
    'sql-log'    => [
        'channel' => 'sql',

    ],
    // 请求ID 服务
    'request_id' => [
        'id_name'               => 'x-request-id', // 字段名称
        'enable'                => false, // 功能是否开启
        'with_log_context'      => true,
        'with_response_body'    => true, // 在内容中是否返回
        'body_warp'             => 'tools', // 包裹字段
        'with_response_headers' => true, // 在header中是否返回
    ],
];
