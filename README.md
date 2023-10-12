# VideoTileSDK

[![Latest Stable Version](http://poser.pugx.org/zgetro/video-tile-sdk/v)](https://packagist.org/packages/zgetro/video-tile-sdk) [![Total Downloads](http://poser.pugx.org/zgetro/video-tile-sdk/downloads)](https://packagist.org/packages/zgetro/video-tile-sdk) [![Latest Unstable Version](http://poser.pugx.org/zgetro/video-tile-sdk/v/unstable)](https://packagist.org/packages/zgetro/video-tile-sdk) [![License](http://poser.pugx.org/zgetro/video-tile-sdk/license)](https://packagist.org/packages/zgetro/video-tile-sdk) [![PHP Version Require](http://poser.pugx.org/zgetro/video-tile-sdk/require/php)](https://packagist.org/packages/zgetro/video-tile-sdk)

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
