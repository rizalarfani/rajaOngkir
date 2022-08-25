<?php

namespace RajaOngkir;

use RizalArfani\RajaOngkir\Config\Config;
use RizalArfani\RajaOngkir\Service\Tracking;

require_once('../src/init.php');

Config::$apiKey = 'bdb85102046029439d45ca5e400d6107';
Config::$typeAccount = 'pro';

$trackings = new Tracking();

$receipt_number = $_POST['receipt_number'];
$courier = $_POST['courier'];

$getTrack = $trackings->getTracking($receipt_number, $courier);

if ($getTrack['rajaongkir']['status']['code'] == 200) {
    $response = [
        'status' => true,
        'message' => $getTrack['rajaongkir']['status']['description'],
        'data' => $getTrack['rajaongkir']['result'],
    ];
} else {
    $response = [
        'status' => false,
        'message' => $getTrack['rajaongkir']['status']['description']
    ];
}

echo json_encode($response);
