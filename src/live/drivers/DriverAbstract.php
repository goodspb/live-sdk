<?php
namespace Goodspb\LiveSdk\Drivers;

use GuzzleHttp\Client as Guzzle;

abstract class DriverAbstract
{
    protected $config = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    abstract public function create($ownerId, $roomName);

    abstract public function get($roomName);

    abstract public function delete($roomName);

    abstract public function kick($roomName, $userId);

    public function post($url, $data, array $header = [])
    {
        $client = new Guzzle();
        $options = [
            'headers' => $header,
            'form_params' => $data,
            'timeout' => \util::array_get($this->config['http']['timeout'], 30),
            'connect_timeout' => \util::array_get($this->config['http']['connect_timeout'], 0),
        ];
        try {
            $result = $client->request('POST', $url, $options);
        } catch (\Exception $e) {

        }
    }
}
