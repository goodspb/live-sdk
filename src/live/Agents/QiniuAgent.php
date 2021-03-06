<?php
namespace Goodspb\LiveSdk\Agents;

use Exception;
use Goodspb\LiveSdk\AgentAbstract;
use Goodspb\LiveSdk\Exceptions\LiveException;
use Goodspb\LiveSdk\Sdk\Qiniu\Mac;
use Goodspb\LiveSdk\Sdk\Qiniu\Client;
use Goodspb\LiveSdk\Sdk\Qiniu\Stream;

class QiniuAgent extends AgentAbstract
{
    protected $client;
    protected $hub;

    public function __construct(array $config, $agentName)
    {
        parent::__construct($config, $agentName);
        $mac = new Mac($config['ak'], $config['sk']);
        $this->client = new Client($mac);
        $this->hub = $this->client->hub($config['hub']);
    }

    /**
     * @return \Goodspb\LiveSdk\Sdk\Qiniu\Hub
     */
    protected function getHub()
    {
        return $this->hub;
    }

    /**
     * @param $streamId
     * @return \Goodspb\LiveSdk\Sdk\Qiniu\Stream
     */
    protected function getStream($streamId)
    {
        $hub = $this->getHub();
        return $hub->stream($streamId);
    }

    public function create($streamId)
    {
        //先尝试获取一个流，当出现错误的时候，再创建一个流
        try {
            $this->getHub()->stream($streamId)->info();
        } catch (Exception $e) {
            $result = $this->getHub()->create($streamId);
            if (!($result instanceof Stream)) {
                throw new LiveException("Can't create stream, " . $result->getMessage());
            }
        }

        $hubName = $this->config('hub');
        return $this->setCreateResult(
            QiniuRTMPPublishURL($this->config('base_url.rtmp_push_url', ''), $hubName, $streamId, $this->config('expire', 3600), $this->config('ak', ''), $this->config('sk', '')),
            QiniuRTMPPlayURL($this->config('base_url.rtmp_play_url', ''), $hubName, $streamId),
            QiniuHLSPlayURL($this->config('base_url.hls_play_url', ''), $hubName, $streamId),
            QiniuHDLPlayURL($this->config('base_url.hdl_play_url', ''), $hubName, $streamId)
        );
    }

    public function status($streamId)
    {
        $stream = $this->getStream($streamId);
        $resultJson = $stream->liveStatus();
        $result = $this->jsonDecode($resultJson);
        if (isset($result['error'])) {
            return false;
        }
        return true;
    }

    public function close($streamId)
    {
        $stream = $this->getStream($streamId);
        return empty($stream->disable());
    }
}
