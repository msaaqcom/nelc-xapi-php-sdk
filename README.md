# xAPI Integration with Saudi NELC (National Center for e-Learning)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/msaaq/nelc-xapi-php-sdk.svg?style=flat-square)](https://packagist.org/packages/msaaq/nelc-xapi-php-sdk)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/msaaq/nelc-xapi-php-sdk/run-tests?label=tests)](https://github.com/msaaq/nelc-xapi-php-sdk/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/msaaq/nelc-xapi-php-sdk/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/msaaq/nelc-xapi-php-sdk/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/msaaq/nelc-xapi-php-sdk.svg?style=flat-square)](https://packagist.org/packages/msaaq/nelc-xapi-php-sdk)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require msaaq/nelc-xapi-php-sdk
```

## Usage

```php
use Msaaq\Nelc\ApiClient;
use Msaaq\Nelc\Common\Actor;
use Msaaq\Nelc\Common\Instructor;
use Msaaq\Nelc\Common\Module;
use Msaaq\Nelc\Enums\ActivityType;
use Msaaq\Nelc\Enums\Language;
use Msaaq\Nelc\StatementClient;
use Msaaq\Nelc\Statements\InitializedBaseStatement;

$client = new ApiClient(
    key: 'username', // required
    secret: 'password', // required
    isSandbox: true, // optional, default is false
);

$statement = new InitializedBaseStatement();
$statement->language = Language::ARABIC;
$statement->timestamp = '2021-01-01 00:00:00';

$statement->actor = new Actor();
$statement->actor->national_id = '123456789';
$statement->actor->email = 'student@msaaq.com';

$statement->instructor = new Instructor();
$statement->instructor->email = 'instructor@msaaq.com';
$statement->instructor->name = 'Instructor Name';

$statement->module = new Module();
$statement->module->url = 'https://academy.msaaq.com/courses/how-to-create-professional-course';
$statement->module->title = 'How to create professional course';
$statement->module->description = 'This series will cover the most important principles of course making, marketing and content preparation.';
$statement->module->activityType = ActivityType::COURSE;
$statement->module->language = $statement->language;

var_dump(StatementClient::setClient($client)->setPlatform('MSAAQ')->send($statement));
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

- [Hussam Abd](https://github.com/hussam3bd)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
