<?php

namespace RizalArfani\RajaOngkir\HttpClient;

use FFI\Exception;
use RizalArfani\RajaOngkir\Config\Config;

class HttpClient
{
    /**
     * Request HTTP Client Method GET
     */
    public static function get($url, $apiKey, $params)
    {
        return HttpClient::call($url, $apiKey, $params, 'GET');
    }

    /**
     * Request HTTP Client Method POST
     */
    public static function post($url, $apiKey, $params)
    {
        return HttpClient::call($url, $apiKey, $params, 'POST');
    }

    /**
     * send request to API server
     * 
     * @param string $url
     * @param string $apiKey
     * @param mixed[] $params
     * @param bool $post
     * @return mixed
     * @throws Exception
     */
    public static function call($url, $apiKey, $params, $method)
    {
        $curl = curl_init();

        if (!$apiKey) {
            throw new Exception('ApiKey adalah null, Anda perlu mengatur api-key dari Config.');
        } else {
            if ($apiKey == '') {
                throw new Exception('Api key tidak boleh kosong, Harap isi apiKey');
            }
        }

        // Jika method GET
        if ($method == 'GET') {
            if ($params) $url .= '?' . http_build_query($params);
        }

        // Curl Option Config
        $curl_options = array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                "content-type: application/x-www-form-urlencoded",
                'key: ' . Config::$apiKey,
            ),
            CURLOPT_FRESH_CONNECT => true,
            CURLOPT_RETURNTRANSFER => true
        );

        // Merge Confin in Congi CurlOptions
        if (count(Config::$curlOptions)) {
            if (Config::$curlOptions[CURLOPT_HTTPHEADER]) {
                $mergedHeaders = array_merge($curl_options[CURLOPT_HTTPHEADER], Config::$curlOptions[CURLOPT_HTTPHEADER]);
                $headerOptions = array(CURLOPT_HTTPHEADER => $mergedHeaders);
            } else {
                $mergedHeaders = array();
                $headerOptions = array(CURLOPT_HTTPHEADER => $mergedHeaders);
            }
            $curl_options = array_replace_recursive($curl_options, Config::$curlOptions, $headerOptions);
        }

        if ($method == 'POST') {
            $curl_options[CURLOPT_POST] = 1;
            if ($params) {
                $curl_options[CURLOPT_POSTFIELDS] = http_build_query($params);
            }
        }

        curl_setopt_array($curl, $curl_options);

        $result = curl_exec($curl);
        if ($result === false) {
            throw new Exception('CURL Error: ' . curl_error($curl), curl_errno($curl));
        } else {
            try {
                $result_array = json_decode($result, true);
                return $result_array;
            } catch (\Throwable $th) {
                throw new Exception('API Request Error unable to json_decode API response: ' . $result . 'for Requset URL ' . $url);
            }
        }
    }
}
