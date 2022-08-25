<?php

namespace RajaOngkir;

use RizalArfani\RajaOngkir\Config\Config;
use RizalArfani\RajaOngkir\service\Regions;

require_once('../src/init.php');

Config::$apiKey = '';
Config::$typeAccount = 'pro';

$id_city = $_GET['city'];

$regions = new Regions();
$get = $regions->getSubDistrict($id_city);

if ($get['rajaongkir']['status']['code'] == 200) {
    echo json_encode($get['rajaongkir']['results']);
}
