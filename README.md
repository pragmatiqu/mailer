# Sending Laravel Mails from Twig Templates

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pragmatiqu/mailer.svg?style=flat-square)](https://packagist.org/packages/pragmatiqu/mailer)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/pragmatiqu/mailer/run-tests?label=tests)](https://github.com/pragmatiqu/mailer/actions?query=workflow%3ATests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/pragmatiqu/mailer/Check%20&%20fix%20styling?label=code%20style)](https://github.com/pragmatiqu/mailer/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/pragmatiqu/mailer.svg?style=flat-square)](https://packagist.org/packages/pragmatiqu/mailer)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[Support Link](#)

We invest a lot of resources into creating [best in class open source packages](https://pragmatiqu.io/open-source). You can support us by [buying one of our paid products](https://pragmatiqu.io/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://pragmatiqu.io/about-us). We publish all received postcards on [our virtual postcard wall](https://pragmatiqu.io/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require pragmatiqu/mailer
```

Don’t forget to run the migrations with:

```bash
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Pragmatiqu\Mail\LiquidMailServiceProvider" --tag="mail"
```

This is the contents of the published config file:

```php
return [
// fill in the blanks…
];
```

## Usage

```php
// fill in the blanks…
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Michael Gerzabek](https://github.com/mgerzabek)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
