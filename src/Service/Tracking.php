<?php

namespace RizalArfani\RajaOngkir\Service;

use RizalArfani\RajaOngkir\Config\Config;
use RizalArfani\RajaOngkir\HttpClient\HttpClient;

class Tracking
{
    protected $api_key;
    protected $url;

    public function __construct()
    {
        $this->api_key = Config::$apiKey;
        $this->url = Config::getBaseUrl();
    }

    /**
     * Method “waybill” untuk digunakan melacak/mengetahui status pengiriman berdasarkan nomor resi.
     * @param string $no_resi Nomor pengiriman
     * @param string $courier Jenis Courier
     * 
     * @return mixed
     */
    public function getTracking($no_resi, $courier)
    {
        return HttpClient::post($this->url . '/waybill', $this->api_key, ['waybill' => $no_resi, 'courier' => $courier]);
    }
}
