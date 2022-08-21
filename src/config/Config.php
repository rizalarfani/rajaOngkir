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
    public static $curlOptions = [];


    /**
     * URL Api Raja Ongkir
     */
    const API_URL_STARTER = 'https://api.rajaongkir.com/starter';
    const API_URL_BASIC = 'https://api.rajaongkir.com/basic';
    const API_URL_PRO = 'https://api.rajaongkir.com/pro';


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
