<?php

// Chek Version PHP
if (version_compare(PHP_VERSION, '5.4', '<')) {
    throw new Exception('PHP version >= 5.4 required');
}

// Check PHP Curl & json decode capabilities.
if (!function_exists('curl_init') || !function_exists('curl_exec')) {
    throw new Exception('Tripay Membutuhkan ekstensi CURL PHP');
}

spl_autoload_register(function ($class) {
    $namespace = str_replace("\\", "/", __NAMESPACE__);
    $className = str_replace("\\", "/", $class);
    $class = CORE_PATH . "/classes/" . (empty($namespace) ? "" : $namespace . "/") . "{$className}.class.php";
    include_once($class);
});
