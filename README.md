# Hetzner Cloud PHP SDK

A PHP SDK for the Hetzner Cloud API: https://docs.hetzner.cloud/

## Installation

You can install the package via composer:

```bash
composer require atsicorp/hetzner-cloud
```

## Usage

```php
$hetznerClient = new \atsicorp\HetznerCloud\HetznerAPIClient($apiKey);
foreach ($hetznerClient->servers()->all() as $server) {
    echo 'ID: '.$server->id.' Name:'.$server->name.' Status: '.$server->status.PHP_EOL;
}
```

### Testing

You can just run `phpunit`. The whole library is based on unit tests and sample responses from the official Hetzner Cloud documentation.

### Changelog

Please see [CHANGELOG](https://github.com/anjasamar/hetzner-cloud-php-sdk/releases) for more information what has changed recently.

### Security

If you discover any security related issues, please email atsidev.io@gmail.com instead of using the issue tracker.

## Credits

- [Anjas Amar Pradana](https://github.com/anjasamar)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
