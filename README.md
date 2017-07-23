# Live-SDK

各直播云整合，暂时只包含以下直播云

* 七牛
* 腾讯云

## 开发状态

开发中，如需在生产环境中使用，请自行承担风险哦。

## 使用方法

#### 非 laravel 框架下的用法

```php
<?php

//配置自己相应的配置项
$live = new \Goodspb\LiveSdk\Live();
$config = require __DIR__ . 'config/live.php';
$live->setConfig($config);
$agent = $live->getAgent();
// 直播间ID
$roomId = '123456';

// 创建一个直播间
$room = $agent->create($roomId);
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
$status = $agent->status($roomId);
var_dump($status);
/*
 * true / false
 */

//关闭房间/断流
$result = $agent->close($roomId);
var_dump($result);
/*
 * true / false
 */

```

#### laravel 框架下的用法
