# Lara Client

Identifying client applications

[![Build Status](https://travis-ci.org/rockbuzz/lara-client.svg?branch=master)](https://travis-ci.org/rockbuzz/lara-client)

## Requirements

PHP: >=7.1

## Install

```bash
$ composer require rockbuzz/lara-client
```

## Configuration
```bash
$ php artisan vendor:publish --provider="Rockbuzz\LaraClient\ServiceProvider"
```
```bash
$ php artisan migrate
```

## Usage
### In App\Http\Kernel.php
```php
protected $middlewareGroups = [
    'api' => [
        'throttle:60,1',
        'bindings',
        \Rockbuzz\LaraClient\Identifier::class
    ],
];
```
### Add client
```php
$ php artisan client:create clientName
```

### Access Example
```php
$httpClient = new Guzzle\Http\Client();
$httpClient->request('GET', 'https://endpoint.com/api/resource', [
    'headers' => [
        'X-API-KEY' => $client->publicKey,
        'X-API-TOKEN' => hash_hmac('sha256', $client->publicKey, $client->secretKey),
     ]
]);
```

## License

The Lara Client is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).