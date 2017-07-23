# Live-SDK

各直播云整合，暂时只包含以下直播云

* 七牛
* 腾讯云

## 使用方法

```php
<?php

//配置自己相应的配置项
$live = \Goodspb\LiveSdk\Live::make([
    'agents' => [
        'qiniu' => [
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
    ],
], 'qiniu');

// 直播间ID
$roomId = '123456';

// 创建一个直播间
$room = $live->create($roomId);
var_dump($room);
/*
 * array(
 *     'rtmp_push_url' => 'rtmp://xxxx.qiniu.com/xxxx?token=xxx&secret=xxx',
 *     'rtmp_play_url' => 'rtmp://xxxx.qiniu.com/xxxx',
 *     'hls_play_url' => 'http://xxx.qiniu.com/xxx.m3nu',
 *     'hdl_play_url' => 'http://xxx.qiniu.com/xxx.flv',
 * );
 */

//查询房间状态
$status = $live->status($roomId);
var_dump($status);
/*
 * true / false
 */

//关闭房间/断流
$result = $live->close($roomId);
var_dump($result);
/*
 * true / false
 */


```
