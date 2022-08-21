<?php

namespace RajaOngkir;

use RajaOngkir\Config\Config;
use RajaOngkir\service\Regions;

require_once('../src/init.php');

Config::$apiKey = 'bdb85102046029439d45ca5e400d6107';
Config::$typeAccount = 'pro';

$regions = new Regions();
var_dump($regions->getSubDistrict('10'));
