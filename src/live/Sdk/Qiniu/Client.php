<?php
namespace Goodspb\LiveSdk\Sdk\Qiniu;

class Client
{
    private $_mac;

    public function __construct($mac)
    {
        $this->_mac = $mac;
    }

    public function hub($hubname)
    {
        return new Hub($this->_mac, $hubname);
    }
}
