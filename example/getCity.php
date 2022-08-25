<?php

// namespace RajaOngkir;

use RizalArfani\RajaOngkir\Config\Config;
use RizalArfani\RajaOngkir\Service\Regions;

require_once('../src/init.php');

Config::$apiKey = '';
Config::$typeAccount = 'pro';

$id_province = $_GET['province'];

$regions = new Regions();
$get = $regions->getCity($id_province);

if ($get['rajaongkir']['status']['code'] == 200) {
    echo json_encode($get['rajaongkir']['results']);
}
