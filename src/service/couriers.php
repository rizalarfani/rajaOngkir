<?php

namespace RizalArfani\RajaOngkir\service\couriers;

use RizalArfani\RajaOngkir\Config\Config;

class Couriers
{
    protected $api_key;
    protected $url;

    public function __construct()
    {
        $this->api_key = Config::$apiKey;
        $this->url = Config::getBaseUrl();
    }

    /**
     * Get List Couriers
     * 
     * @return mixed
     */
    public static function getCouriers()
    {
        return Config::$supportedCouriers[Config::$typeAccount];
    }
}
