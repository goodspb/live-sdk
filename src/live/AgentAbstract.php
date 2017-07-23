<?php
namespace Goodspb\LiveSdk;

use Goodspb\LiveSdk\Exceptions\LiveException;
use GuzzleHttp\Client as Guzzle;

abstract class AgentAbstract
{
    protected $config = [];
    protected $agentName;

    public function __construct(array $config, $agentName)
    {
        $this->config = $config;
        $this->agentName = $agentName;
    }

    /**
     * Get config
     * @param null $key
     * @param null $default
     * @return array|mixed
     */
    protected function config($key = null, $default = null)
    {
        return is_null($key) ? $this->config : fnGet($this->config, $key, $default);
    }

    /**
     * Decode json
     * @param $json
     * @return array
     * @throws LiveException
     */
    protected function jsonDecode($json)
    {
        $array = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new LiveException('decode json error');
        }
        return $array;
    }

    /**
     * Get agent name
     * @return string
     */
    public function getAgentName()
    {
        return $this->agentName;
    }

    public function post($url, $data, array $header = [])
    {
        $client = new Guzzle();
        $options = [
            'headers' => $header,
            'form_params' => $data,
            'timeout' => fnGet($this->config, 'http.timeout', 30),
            'connect_timeout' => fnGet($this->config, 'http.connect_timeout', 0),
        ];
        try {
            $response = $client->request('POST', $url, $options);
            return $response->getBody();
        } catch (\Exception $e) {
            return false;
        }
    }

    public function get($url, $params = [], array $header = [])
    {
        $client = new Guzzle();
        $options = [
            'headers' => $header,
            'timeout' => fnGet($this->config, 'http.timeout', 30),
            'connect_timeout' => fnGet($this->config, 'http.connect_timeout', 0),
        ];
        try {
            $response = $client->request('GET', $url . (empty($params) ? '' : '?' . http_build_query($params)), $options);
            return $response->getBody();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $streamId
     * @return array
     */
    abstract public function create($streamId);

    /**
     * @param $streamId
     * @return array
     */
    abstract public function status($streamId);

    /**
     * @param $streamId
     * @return bool
     */
    abstract public function close($streamId);

    public function setCreateResult($rtmpPushUrl, $rtmpPlayUrl, $hlsPlayUrl = '', $hdlPlayUrl = '')
    {
        return [
            'rtmp_push_url' => $rtmpPushUrl,
            'rtmp_play_url' => $rtmpPlayUrl,
            'hls_play_url' => $hlsPlayUrl,
            'hdl_play_url' => $hdlPlayUrl,
        ];
    }
}
