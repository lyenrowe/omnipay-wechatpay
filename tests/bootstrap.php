<?php

error_reporting(E_ALL | E_STRICT);

//需要改成实际的商户id
define('APP_ID', 'wx123123');
define('MCH_ID', '123123123');
define('API_KEY', '123123123');
// include the composer autoloader
$autoloader = require __DIR__ . '/../vendor/autoload.php';

// autoload abstract TestCase classes in test directory
$autoloader->add('Omnipay', __DIR__);
