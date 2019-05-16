<?php

require __DIR__ . '/index.php';
require __DIR__ . '/vendor/autoload.php';

$api = new VideoTile('http://vt-api.local/');

echo $api->getUserById('WISHADMIN', 394);