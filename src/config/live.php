<?php

return [
    'default' => '',
    'drivers' => [

        /*
         * 七牛直播云
         */
        'qiniu' => [
            'ak' => '',
            'sk' => '',
        ],

        /*
         * 金山云
         */
        'ksyun' => [
            'accesskey' => '',
            'secretkey' => '',
        ],

        /*
         * 腾讯云
         */

        'qcloud' => [

        ],
    ],

    'http' => [
        'timeout' => 30,
        'connect_timeout' => 0,
    ],
];
