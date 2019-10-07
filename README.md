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
### Access Example
```php
$client = new Guzzle\Http\Client();
$client->request('GET', 'endpoint', [
    'headers' => [
        'X-API-KEY' => env('PUBLIC_KEY'),
        'X-API-TOKEN' => hash_hmac('sha256', env('PUBLIC_KEY'), env('SECRET_KEY')),
     ]
]);
```

### Optional
```php
$publicKey = \Rockbuzz\LaraClient\StrGenerate::publicKey();
$secretKey = \Rockbuzz\LaraClient\StrGenerate::secretKey();
```

## License

The Lara Client is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).