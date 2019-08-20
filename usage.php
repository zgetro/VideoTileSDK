<?php

require __DIR__ . '/index.php';
require __DIR__ . '/vendor/autoload.php';

$api = new VideoTile('http://vt-api.local', 'admin_token', 'vendor_lms_name');

echo $api->generateLoginUrl('user_token');
