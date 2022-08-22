<?php

namespace RizalArfani\RajaOngkir;

use FFI\Exception;

// Chek Version PHP
if (version_compare(PHP_VERSION, '5.4', '<')) {
    throw new Exception('PHP version >= 5.4 required');
}

// Check PHP Curl & json decode capabilities.
if (!function_exists('curl_init') || !function_exists('curl_exec')) {
    throw new Exception('Tripay Membutuhkan ekstensi CURL PHP');
}

// Load Class Config
require_once('config/Config.php');

// Load Class HttpClient
require_once('httpClient/httpClient.php');

// Load Service
require_once('service/regions.php');
require_once('service/cost.php');
