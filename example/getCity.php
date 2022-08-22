<?php

namespace RajaOngkir;

use RajaOngkir\Config\Config;
use RajaOngkir\service\Regions;

require_once('../src/init.php');

Config::$apiKey = 'bdb85102046029439d45ca5e400d6107';
Config::$typeAccount = 'pro';

$id_province = $_GET['province'];

$regions = new Regions();
$get = $regions->getCity($id_province);

if ($get['rajaongkir']['status']['code'] == 200) {
    echo json_encode($get['rajaongkir']['results']);
}
