<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/index.php';
require __DIR__ . '/vendor/autoload.php';

$api = new VideoTile('http://vt-api.local', 'WISHADMIN');

echo $api->getUserById(394);
