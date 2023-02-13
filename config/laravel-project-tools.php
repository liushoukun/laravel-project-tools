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
        'with_response_body' => true,
    ],
];
