<?php

// namespace RajaOngkir;

use RizalArfani\RajaOngkir\Config\Config;
use RizalArfani\RajaOngkir\Service\Cost;

require_once('../src/init.php');

Config::$apiKey = '';
Config::$typeAccount = 'pro';

$cost = new Cost();

$params = [
    'origin' => '386', // ID kota/kabupaten atau kecamatan asal
    'originType' => 'city', // Tipe origin: 'city' atau 'subdistrict'
    'destination' => $_POST['city'], // ID kota/kabupaten atau kecamatan tujuan
    'destinationType' => 'city', // Tipe destination: 'city' atau 'subdistrict'.
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
        'message' => $getCost['rajaongkir']['status']['description'],
    ];
}
echo json_encode($response, true);
