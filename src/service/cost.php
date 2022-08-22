<?php

namespace RajaOngkir\service\cost;

use RajaOngkir\Config\Config;
use RajaOngkir\HttpClient\HttpClient;

class Cost
{
    protected $api_key;
    protected $url;

    public function __construct()
    {
        $this->api_key = Config::$apiKey;
        $this->url = Config::getBaseUrl();
    }

    /**
     * Get Cost
     * 
     * @return mixed
     */
    public function getCost($params = [])
    {
        return HttpClient::post($this->url . '/cost', $this->api_key, $params);
    }
}
