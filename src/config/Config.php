<?php

namespace RajaOngkir\Config;

use FFI\Exception;

class Config
{
    /**  
     * Your api key for the Raja Ongkir
     * 
     * @static
     */
    public static $apiKey;

    /**
     * Your Type account for the Raja Ongkir
     * 
     * @static
     */
    public static $typeAccount = 'starter';

    /**
     * Default options for every request
     * 
     * @static
     */
    public static $curlOptions = array();

    /**
     * Rajaongkir courier list.
     * 
     * @static
     */
    public static $couriersList = [
        'jne'       => 'Jalur Nugraha Ekakurir (JNE)',
        'pos'       => 'POS Indonesia (POS)',
        'tiki'      => 'Citra Van Titipan Kilat (TIKI)',
        'pcp'       => 'Priority Cargo and Package (PCP)',
        'esl'       => 'Eka Sari Lorena (ESL)',
        'rpx'       => 'RPX Holding (RPX)',
        'pandu'     => 'Pandu Logistics (PANDU)',
        'wahana'    => 'Wahana Prestasi Logistik (WAHANA)',
        'sicepat'   => 'SiCepat Express (SICEPAT)',
        'j&t'       => 'J&T Express (J&T)',
        'pahala'    => 'Pahala Kencana Express (PAHALA)',
        'cahaya'    => 'Cahaya Logistik (CAHAYA)',
        'sap'       => 'SAP Express (SAP)',
        'jet'       => 'JET Express (JET)',
        'indah'     => 'Indah Logistic (INDAH)',
        'slis'      => 'Solusi Express (SLIS)',
        'expedito*' => 'Expedito*',
        'dse'       => '21 Express (DSE)',
        'first'     => 'First Logistics (FIRST)',
        'ncs'       => 'Nusantara Card Semesta (NCS)',
        'star'      => 'Star Cargo (STAR)',
    ];

    /**
     * URL Api Raja Ongkir
     */
    const API_URL_STARTER = 'https://api.rajaongkir.com/starter';
    const API_URL_BASIC = 'https://api.rajaongkir.com/basic';
    const API_URL_PRO = 'https://pro.rajaongkir.com/api';


    /** 
     * Get BaseUrl
     * 
     * @return string Raja Ongkir API URL, depends on type_account
     */
    public static function getBaseUrl()
    {
        switch (Config::$typeAccount) {
            case 'starter':
                return Config::API_URL_STARTER;
                break;
            case 'basic':
                return Config::API_URL_BASIC;
                break;
            case 'pro':
                return Config::API_URL_PRO;
                break;
            default:
                throw new Exception("The RajaOngkir account type set does not match. Choose one: starter, basic, pro.", 1);
                break;
        }
    }
}
