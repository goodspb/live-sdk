<?php

return [
    'upstream' => [
        /*
         * 比例最终加起来要100
         * 'qiniu' => 50,
         * 'jinshan' => 50,
         */
        'qiniu' => 100,
    ],
    'agents' => [
        'qiniu' => [
            'enable' => true,
            'class' => Goodspb\LiveSdk\Agents\QiniuAgent::class,
            'hub' => '',        //直播空间名
            'base_url' => [     //绑定域名
                'rtmp_push_url' => '',
                'rtmp_play_url' => '',
                'hls_play_url' => '',
                'hdl_play_url' => '',
            ],
            'expire' => '',     //推流地址过期时间
            'ak' => '',
            'sk' => '',
        ],
        'qcloud' => [
            'enable' => true,
            'class' => Goodspb\LiveSdk\Agents\QcloudAgent::class,
            'api_base_url' => 'http://fcgi.video.qcloud.com/common_access',
            'appid' => '',
            'bizid' => '',      //直播码
            'expire' => 86400,  //推流过期时间
            'push_key' => '',   //推流防盗链Key
            'api_key' => '',    //Api鉴权Key
        ],
    ],
    'http' => [
        'timeout' => 30,
        'connect_timeout' => 0,
    ],
];
