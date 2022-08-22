<?php

namespace RizalArfani\RajaOngkir\service;

use RizalArfani\RajaOngkir\HttpClient\HttpClient;
use RizalArfani\RajaOngkir\Config\Config;

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

    /**
     * Method "city" digunakan untuk mendapatkan daftar kota/kabupaten yang ada di Indonesia.
     * @param string $id_prov
     * @param string $id_kab
     * 
     * @return mixed
     */
    public function getCity($id_prov = '', $id_kab = '')
    {
        return HttpClient::get($this->url . '/city', $this->api_key, ['id' => $id_kab, 'province' => $id_prov]);
    }

    /**
     * Method "subdistrict" digunakan untuk mendapatkan daftar kecamatan yang ada di Indonesia.
     * @param string $id_kab
     * @param string $id_kec
     * 
     * @return mixed
     */
    public function getSubDistrict($id_kab, $id_kec = '')
    {
        return HttpClient::get($this->url . '/subdistrict', $this->api_key, ['city' => $id_kab, 'id' => $id_kec]);
    }
}
