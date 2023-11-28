# TTLock Cloud API SDK

PHP SDK for [TTLock Cloud API v3](https://euopen.ttlock.com/document/doc?urlName=cloud/oauth2/getAccessTokenEn.html)

## Installation

See [clients & adapters](https://docs.php-http.org/en/latest/clients.html) list in HTTPlug documentation
if you're using another HTTP client (not Guzzle 7).

HTTP client should be compatible with PSR-18 (implementing `psr/http-client-implementation`).

```shell
composer require sunnyphp/ttlock php-http/guzzle7-adapter
```

```php
<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use SunnyPHP\TTLock\Configuration;
use SunnyPHP\TTLock\Entrypoint;
use SunnyPHP\TTLock\Request\Lock\GetList;
use SunnyPHP\TTLock\Request\Lock\Initialize;
use SunnyPHP\TTLock\Request\OAuth2\AccessToken;
use SunnyPHP\TTLock\Request\User\Register;
use SunnyPHP\TTLock\Transport;

// initial configuration
$entrypoint = new Entrypoint(
	new Configuration('client_id', 'client_secret', /* access token if needed */),
	new Transport(\Http\Adapter\Guzzle7\Client::createWithConfig([
		'verify' => false,	// disable certificates check
	])),
);

// register user; retrieve TTLock Cloud API username
$register = $entrypoint->getUserRegister(new Register('username', 'password'));
var_dump($register->getResponseArray());

// get access token; retrieve access token, refresh token, expiration, etc
$tokenResponse = $entrypoint->getOAuth2AccessToken(new AccessToken($register->getUsername(), 'password'));
var_dump($tokenResponse->getResponseArray());

// save token response to future requests or refreshing token
// ...

// inject access token to entrypoint configuration (most of the requests required access token)
$entrypoint = $entrypoint->withConfigurationAccessToken($tokenResponse->getAccessToken());

// initialize new lock; access token used under hood; retrieve lockId, keyId
$lockData = 'TTLock SDK should return lockData here';
$newLockIds = $entrypoint->getLockInitialize(new Initialize($lockData));
var_dump($newLockIds->getResponseArray());

// get all initialized locks
$locks = $entrypoint->getLockList(new GetList());
var_dump($locks->getResponseArray());

// other requests
```

## Exception structure

- `\SunnyPHP\TTLock\Exception\ApiException` - communication or system errors
	- `\SunnyPHP\TTLock\Exception\CommonException` - if response has errors
    - `\SunnyPHP\TTLock\Exception\KeyException` - if response has `Ekey`-associated errors
    - `\SunnyPHP\TTLock\Exception\GatewayException` - if response has `Gateway`-associated errors
    - `\SunnyPHP\TTLock\Exception\LockException` - if response has `Lock`-associated errors
    - `\SunnyPHP\TTLock\Exception\PasscodeException` - if response has `Passcode` or `IC`-associated errors
- `\Webmozart\Assert\InvalidArgumentException` - if passed data is invalid
