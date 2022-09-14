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

The base concept of this package is to provide a simple way to send xAPI statements to Saudi NELC (National Center for
e-Learning) LRS (Learning Record Store).

## 1. Create Api Client.

The first step to use the SDK is to create an instance of the `ApiClient`.
The `ApiClient` is the main entry point to the SDK.
It is responsible for creating the other objects and for sending the requests to the API.

The `ApiClient` required the following credentials:

- Key
- Secret
- Platform Name

> You need to contact NELC to provide you with your integration credentials.

```php
use Msaaq\Nelc\ApiClient;

$client = new ApiClient(
    key: 'username', // required
    secret: 'password', // required
    isSandbox: true, // optional, default is false
);

$platformName = 'your-platform-name'; // required
```

After we created our client, we can use it to send statements to the NELC LRS.

## 2. Send Statement

To send a statement to the NELC LRS, we need to create an instance of the `StatementClient` class.

The `StatementClient` required an instance of the `ApiClient` that we've created in the previous step, and
the `$platformName`.

```php
use Msaaq\Nelc\StatementClient;

$statementClient = StatementClient::setClient($client)->setPlatform($platformName);
```

Now we are almost ready to send our first statement to the NELC LRS, we just need to create an instance of
the `Statement` that we are going to send, but first let's understand the `Statement` classes structure.

### Statement Structure

You can think of the `Statement` as an event that happened in your application, and we have 8 types of statements for
each case:

| Statement Name | Description | Statement Class |
| -------------- | ----------- | --------------- |
| registered | Indicates the actor is officially enrolled or inducted in an activity. | `RegisteredStatement` |
| initialized | Indicates the activity provider has determined that the actor successfully started an activity. | `InitializedStatement` |
| watched | Indicates that the actor has watched the object. This verb is typically applicable only when the object represents dynamic, visible content such as a movie, a television show or a public performance. This verb is a more specific form of the verbs experience, play and consume. | `WatchedStatement` |
| completed | Indicates the actor finished or concluded the activity normally. | `CompletedStatement` |
| progressed | Indicates a value of how much of an actor has advanced or moved through an activity. | `ProgressedStatement` |
| rated | Action of giving a rating to an object. Should only be used when the action is the rating itself, as opposed to another action such as "reading" where a rating can be applied to the object as part of that action. In general the rating should be included in the Result with a Score object. | `RatedStatement` |
| earned | Indicates that the actor has earned or has been awarded the object. | `EarnedStatement` |
| attempted | Indicates the actor made an effort to access the object. An attempt statement without additional activities could be considered incomplete in some cases. | `AttemptedStatement` |

Every statement requires the following:

- `Actor` which is the user that performed the action (Student).
    - It has the following properties:
        - `national_id` which is the user national id.
        - `email` which is the user email.
- `Instructor` which is the course or module instructor (Teacher).
    - It has the following properties:
        - `name` which is the instructor name.
        - `email` which is the instructor email.
- `Module` which is the course or module that the student is enrolled in.
    - It has the following properties:
        - `url` which is the module url.
        - `name` which is the module name.
        - `description` which is the module description.
        - `language` which is the module language, and it must be an instance of `Language`.
        - `activityType` which is the module type.
            - It can be one of the following:
                - `ActivityType::COURSE`
                - `ActivityType::LESSON`
                - `ActivityType::VIDEO`
                - `ActivityType::MODULE`
                - `ActivityType::UNIT_TEST`
                - `ActivityType::CERTIFICATE`

Let's prepare the `Actor` and `Instructor` objects, as we are going to use them with all of our statements.

```php
use Msaaq\Nelc\Common\Actor;
use Msaaq\Nelc\Common\Instructor;

$actor = new Actor();
$actor->national_id = '123456789';
$actor->email = 'student@msaaq.com';

$instructor = new Instructor();
$instructor->email = 'instructor@msaaq.com';
$instructor->name = 'Instructor Name';
```

```php
use Msaaq\Nelc\Common\Module;
use Msaaq\Nelc\Enums\ActivityType;
use Msaaq\Nelc\Enums\Language;
use Msaaq\Nelc\Statements\InitializedStatement;

$statement = new InitializedStatement();
$statement->language = Language::ARABIC;
$statement->timestamp = '2021-01-01 00:00:00';

$statement->actor = $actor;
$statement->instructor = $instructor;

$statement->module = new Module();
$statement->module->url = 'https://academy.msaaq.com/courses/how-to-create-professional-course';
$statement->module->title = 'How to create professional course';
$statement->module->description = 'This series will cover the most important principles of course making, marketing and content preparation.';
$statement->module->activityType = ActivityType::COURSE;
$statement->module->language = $statement->language;

var_dump($statementClient->send($statement));
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
