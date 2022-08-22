<?php

namespace RajaOngkir;

use RajaOngkir\Config\Config;
use RajaOngkir\service\Regions;

require_once('../src/init.php');

Config::$apiKey = 'bdb85102046029439d45ca5e400d6107';
Config::$typeAccount = 'pro';

$id_city = $_GET['city'];

$regions = new Regions();
$get = $regions->getSubDistrict($id_city);

if ($get['rajaongkir']['status']['code'] == 200) {
    echo json_encode($get['rajaongkir']['results']);
}
