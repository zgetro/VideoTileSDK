# VideoTileSDK

[![Latest Stable Version](http://poser.pugx.org/zgetro/video-tile-sdk/v)](https://packagist.org/packages/zgetro/video-tile-sdk) [![Total Downloads](http://poser.pugx.org/zgetro/video-tile-sdk/downloads)](https://packagist.org/packages/zgetro/video-tile-sdk) [![Latest Unstable Version](http://poser.pugx.org/zgetro/video-tile-sdk/v/unstable)](https://packagist.org/packages/zgetro/video-tile-sdk) [![License](http://poser.pugx.org/zgetro/video-tile-sdk/license)](https://packagist.org/packages/zgetro/video-tile-sdk) [![PHP Version Require](http://poser.pugx.org/zgetro/video-tile-sdk/require/php)](https://packagist.org/packages/zgetro/video-tile-sdk)

The VideoTile SDK is a wrapper for the [VideoTile API](http://api.videotilehost.com). 13 methods are included as a starting point, more methods may be included during the life-cycle of the SDK & API.

The SDK is provided as a starting point to get to grips with the API, a quick & easy solution that you can include in your code base, alternatively; you can use the API directly and reference the API.

Full documentation can be found [here](http://api.videotilehost.com/docs/#our-api).

## Requirements
- PHP >= 7.2.5
- ext-json
- guzzlehttp/guzzle ^7.4

## Installation

```
composer require zgetro/video-tile-sdk
```

## Example usage

```php
<?php
require __DIR__ . '/vendor/autoload.php';

// Specify the VideoTile endpoint, your admin token & LMS vendor name.
$api = new VideoTileSdk\VideoTile('http://api.videotilehost.com/', 'admin_token', 'vendor_lms_name');

echo $api->generateLoginUrl('user_token');
```

## Running Tests

To run the full test suite:

```
composer test
```

## Changelog
See [CHANGELOG.md](CHANGELOG.md) for recent changes.

## License
MIT
