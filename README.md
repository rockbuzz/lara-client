# Lara Client

Identifying client applications

travis markdown

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
### Example
```php
$client = new Guzzle\Http\Client();
$client->request('GET', 'endpoint', [
    'headers' => [
        'X-API-KEY' => env('PUBLIC_KEY'),
        'X-API-TOKEN' => hash_hmac('sha256', env('PUBLIC_KEY'), env('SECRET_KEY')),
     ]
]);

```

## License

The Lara Client is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).