<?php

return [
    //异常配置
    'exception'  => [
        'common_code' => 9999999,// 通用错误码
    ],

    // 请求ID 服务
    'request_id' => [
        'enable'                => true, // 功能是否开启
        'id_name'               => 'x-request-id', // 字段名称
        'with_log_context'      => true, // 是否包含请求ID
        'with_response_headers' => true, // 在header中是否返回
        'with_response_body'    => true, // 在内容中是否返回
        'body_warp'             => 'request', // 包裹字段

    ],
];
