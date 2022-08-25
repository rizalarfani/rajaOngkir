<?php

// namespace RajaOngkir;

use RizalArfani\RajaOngkir\Config\Config;
use RizalArfani\RajaOngkir\Service\Cost;

require_once('../src/init.php');

Config::$apiKey = '';
Config::$typeAccount = 'pro';

$cost = new Cost();

$params = [
    'origin' => '472', // ID kota/kabupaten atau kecamatan asal
    'originType' => 'city',
    'destination' => $_POST['city'], // ID kota/kabupaten atau kecamatan tujuan
    'destinationType' => 'city',
    'weight' => $_POST['weight'], // Berat Kiriman dalam gram,
    'courier' => $_POST['courier'], // Code courier
];

$getCost = $cost->getCost($params);
if ($getCost['rajaongkir']['status']['code'] == 200) {
    $response = [
        'status' => true,
        'message' => 'Berhasil get cost!',
        'data' => $getCost['rajaongkir']['results'][0]['costs'],
    ];
} else {
    $response = [
        'status' => false,
        'message' => $decode['rajaongkir']['status']['description'],
    ];
}
echo json_encode($response, true);
