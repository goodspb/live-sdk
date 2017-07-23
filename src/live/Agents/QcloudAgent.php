<?php
namespace Goodspb\LiveSdk\Agents;

use Goodspb\LiveSdk\AgentAbstract;

class QcloudAgent extends AgentAbstract
{

    public function create($streamId)
    {
        $bizid = $this->config('bizid');
        $realSteamId = $bizid . '_' . $streamId;
        $time = strtoupper(base_convert($this->config('expire', 86400) + time(), 10, 16));
        $secret = $this->pushSign($realSteamId, $time, $this->config('push_key'));
        return $this->setCreateResult(
            sprintf("rtmp://%s.livepush.myqcloud.com/live/%s?txSecret=%s&txTime=%s", $bizid, $realSteamId, $secret, $time),
            sprintf("rtmp://%s.liveplay.myqcloud.com/live/%s", $bizid, $realSteamId),
            sprintf("http://%s.liveplay.myqcloud.com/live/%s.m3u8", $bizid, $realSteamId),
            sprintf("http://%s.liveplay.myqcloud.com/live/%s.flv", $bizid, $realSteamId)
        );
    }

    public function status($streamId)
    {
        $url = $this->config('api_base_url');
        $params = [
            'appid' => $this->config('appid'),
            't' => $t = time(),
            'sign' => $this->apiSign($this->config('api_key'), $t),
            'interface' => 'Live_Channel_GetStatus',
            'Param.s.channel_id' => $this->config('bizid') . '_' . $streamId
        ];
        if (false === $result = $this->get($url, $params)) {
            return false;
        }
        try {
            $array = $this->jsonDecode($result);
        } catch (\Exception $e) {
            return false;
        }
        //0:断流；1:开启；3:关闭
        return fnGet($array, 'output.status') == 1;
    }

    public function close($streamId)
    {
        $url = $this->config('api_base_url');
        $params = [
            'appid' => $this->config('appid'),
            't' => $t = time(),
            'sign' => $this->apiSign($this->config('api_key'), $t),
            'interface' => 'Live_Channel_SetStatus',
            'Param.s.channel_id' => $this->config('bizid') . '_' . $streamId,
            'Param.n.status' => 2,  //0表示禁用； 1表示允许推流；2表示断流
        ];
        if (false === $result = $this->get($url, $params)) {
            return false;
        }
        try {
            $array = $this->jsonDecode($result);
        } catch (\Exception $e) {
            return false;
        }
        return fnGet($array, 'ret', 1) == 0;
    }

    protected function apiSign($apiKey, $t)
    {
        return md5($apiKey . $t);
    }

    protected function pushSign($steamId, $time, $pushKey)
    {
        return md5($pushKey . $steamId . $time);
    }
}
