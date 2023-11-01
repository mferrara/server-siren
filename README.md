# Someone has to sound the alarm..

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mferrara/server-siren.svg?style=flat-square)](https://packagist.org/packages/mferrara/server-siren)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/mferrara/server-siren/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/mferrara/server-siren/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/mferrara/server-siren/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/mferrara/server-siren/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mferrara/server-siren.svg?style=flat-square)](https://packagist.org/packages/mferrara/server-siren)

Basic metrics collection for Laravel applications.

## Installation

You can install the package via composer:

```bash
composer require mferrara/server-siren
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="server-siren-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="server-siren-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="server-siren-views"
```

## Usage

Collect and store metrics

```php
$siren = new Mferrara\Siren\Siren();
$siren->process();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Mike Ferrara](https://github.com/mferrara)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
