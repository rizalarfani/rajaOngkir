<?php

namespace RajaOngkir\service;

use RajaOngkir\HttpClient\HttpClient;
use RajaOngkir\Config\Config;

class Regions
{
    protected $api_key;
    protected $url;

    public function __construct()
    {
        $this->api_key = Config::$apiKey;
        $this->url = Config::getBaseUrl();
    }

    /**
     * Method "province" digunakan untuk mendapatkan daftar propinsi yang ada di Indonesia.
     * @param string $id_prov
     * 
     * @return mixed
     * @throws Exception
     */
    public  function getprovince($id_prov = '')
    {
        return HttpClient::get($this->url . '/province', $this->api_key, ['id' => $id_prov]);
    }
}
