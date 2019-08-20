# VideoTileSDK

The VideoTile SDK is a wrapper for the [VideoTile API](http://api.videotilehost.com). 13 methods are included as a starting point, more methods may be included during the life-cycle of the SDK & API.

The SDK is provided as a starting point to get to grips with the API, a quick & easy solution that you can include in your code base, alternatively; you can use the API directly and reference the API.

Full documentation can be found [here](http://api.videotilehost.com/docs/#our-api).

# Example usage

```php

<?php

require __DIR__ . '/index.php';
require __DIR__ . '/vendor/autoload.php';

// special the VideoTile endpoint, your admin token & LMS vendor name.
$api = new VideoTile('http://api.videotilehost.com/', 'admin_token', 'vendor_lms_name');

echo $api->generateLoginUrl('user_token');
```
