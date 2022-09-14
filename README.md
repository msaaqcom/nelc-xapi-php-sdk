# xAPI Integration with Saudi NELC (National Center for e-Learning)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/msaaq/nelc-xapi-php-sdk.svg?style=flat-square)](https://packagist.org/packages/msaaq/nelc-xapi-php-sdk)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/msaaq/nelc-xapi-php-sdk/run-tests?label=tests)](https://github.com/msaaq/nelc-xapi-php-sdk/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/msaaq/nelc-xapi-php-sdk/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/msaaq/nelc-xapi-php-sdk/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/msaaq/nelc-xapi-php-sdk.svg?style=flat-square)](https://packagist.org/packages/msaaq/nelc-xapi-php-sdk)

The base concept of this package is to provide a simple way to send xAPI statements to Saudi NELC (National Center for
e-Learning) LRS (Learning Record Store).

## Installation

You can install the package via composer:

```bash
composer require msaaq/nelc-xapi-php-sdk
```

## Usage

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

| Name | Description | Class |
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
        - `url`* which is the module url.
        - `name`* which is the module name.
        - `description`* which is the module description.
        - `language`* which is the module language, and it must be an instance of `Language`.
        - `activityType`* which is the module type.
            - It can be one of the following:
                - `ActivityType::COURSE`
                - `ActivityType::LESSON`
                - `ActivityType::VIDEO`
                - `ActivityType::MODULE`
                - `ActivityType::UNIT_TEST`
                - `ActivityType::CERTIFICATE`
        - `duration` which is the module duration in seconds (this is only when the `activityType`
          is `ActivityType::VIDEO`).
        - `score` which is the module score (this is only when the `activityType` is `ActivityType::UNIT_TEST`).
    - `language` is an enum that has the following values:
        - `Language::ARABIC`
        - `Language::ENGLISH`
    - `timestamp` The date/time, following the ISO 8601 format such as `2022-09-14T10:33:43+03:00`.
        - If you don't provide a timestamp, the current date/time will be used.

> For the `timestamp` you can use [Carbon](https://carbon.nesbot.com/docs/), you can use the `toIso8601String()` method
> to get the correct format.

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

Now we are ready to create our first statement:

### Registered Statement

The `RegisteredStatement` is used to indicate that the student is officially enrolled or inducted in an activity.

```php
use Msaaq\Nelc\Common\Module;
use Msaaq\Nelc\Enums\ActivityType;
use Msaaq\Nelc\Enums\Language;
use Msaaq\Nelc\Statements\RegisteredStatement;

$statement = new RegisteredStatement();
$statement->language = Language::ENGLISH;
$statement->timestamp = '2022-09-14T10:33:43+03:00';

$statement->actor = $actor;
$statement->instructor = $instructor;

$statement->module = new Module();
$statement->module->url = 'https://academy.msaaq.com/courses/how-to-create-professional-course';
$statement->module->title = 'How to create professional course';
$statement->module->description = 'This series will cover the most important principles of course making, marketing and content preparation.';
$statement->module->language = $statement->language;
$statement->module->activityType = ActivityType::COURSE;

var_dump($statementClient->send($statement));
```

### Initialized Statement

The `InitializedStatement` is used to indicate that the actor (student) has successfully started the course.

```php
use Msaaq\Nelc\Common\Module;
use Msaaq\Nelc\Enums\ActivityType;
use Msaaq\Nelc\Enums\Language;
use Msaaq\Nelc\Statements\InitializedStatement;

$statement = new InitializedStatement();
$statement->language = Language::ENGLISH;
$statement->timestamp = '2022-09-14T10:33:43+03:00';

$statement->actor = $actor;
$statement->instructor = $instructor;

$statement->module = new Module();
$statement->module->url = 'https://academy.msaaq.com/courses/how-to-create-professional-course';
$statement->module->title = 'How to create professional course';
$statement->module->description = 'This series will cover the most important principles of course making, marketing and content preparation.';
$statement->module->language = $statement->language;
$statement->module->activityType = ActivityType::COURSE;

var_dump($statementClient->send($statement));
```

### Watched Statement

The `WatchedStatement` is used to indicate that the actor (student) has watched the object (video).

This statement requires more properties than the previous statements, as it has the following properties:

- `parent` which is an instance `Module` which is the course in our case.
- `completed` which is a boolean value that indicates if the video is completed or not.
- `browserInformation`
    - `family` which is the browser family (Mozilla, Google, ex..).
    - `name` which is the browser name (Firefox, Chrome, ex..).
    - `version` which is the browser version.

```php
use Msaaq\Nelc\Common\Module;
use Msaaq\Nelc\Common\BrowserInformation;
use Msaaq\Nelc\Enums\ActivityType;
use Msaaq\Nelc\Enums\Language;
use Msaaq\Nelc\Statements\WatchedStatement;

$statement = new WatchedStatement();
$statement->language = Language::ENGLISH;
$statement->timestamp = '2022-09-14T10:33:43+03:00';

$browserInformation = new BrowserInformation();
$browserInformation->family = 'Mozilla';
$browserInformation->name = 'Firefox';
$browserInformation->version = '92.0';

$statement->browserInformation = $browserInformation;

$statement->actor = $actor;
$statement->instructor = $instructor;

// Our parent module is the course
$parent = new Module();
$parent->url = 'https://academy.msaaq.com/courses/how-to-create-professional-course';
$parent->title = 'How to create professional course';
$parent->description = 'This series will cover the most important principles of course making, marketing and content preparation.';
$parent->language = $statement->language;
$parent->activityType = ActivityType::COURSE;

$statement->parent = $parent;

// Our module is the video
$statement->module = new Module();
$statement->module->url = 'https://academy.msaaq.com/courses/how-to-create-professional-course/contents/11919';
$statement->module->title = 'Introduction to creating training courses';
$statement->module->description = 'In this video, we will talk about the importance of creating training courses and the benefits of doing so.';
$statement->module->language = $statement->language;
$statement->module->activityType = ActivityType::VIDEO;
// Duration in seconds, required when the activity type is VIDEO
$statement->module->duration = 630; // 10:30 minutes

$statement->completed = true;

var_dump($statementClient->send($statement));
```

### Attempted Statement

The `AttemptedStatement` is used to indicate that the actor (student) has attempted the object (quiz).

This statement requires more properties than the previous statements, as it has the following properties:

- `parent`
- `completed`
- `browserInformation`
- `succeeded` which is a boolean value that indicates if the quiz is succeeded or not.
- `attemptId` which is a unique identifier for the attempt.

```php
use Msaaq\Nelc\Common\Module;
use Msaaq\Nelc\Common\Score;
use Msaaq\Nelc\Enums\ActivityType;
use Msaaq\Nelc\Enums\Language;
use Msaaq\Nelc\Statements\AttemptedStatement;

$statement = new AttemptedStatement();
$statement->language = Language::ENGLISH;
$statement->timestamp = '2022-09-14T10:33:43+03:00';

$statement->browserInformation = $browserInformation;

$statement->actor = $actor;
$statement->instructor = $instructor;

// Our parent module is the course
$statement->parent = $parent;

// Our module is the video
$statement->module = new Module();
$statement->module->url = 'https://academy.msaaq.com/courses/how-to-create-professional-course/contents/11919';
$statement->module->title = 'Quiz title';
$statement->module->description = 'Quiz description';
$statement->module->language = $statement->language;
$statement->module->activityType = ActivityType::UNIT_TEST;
// score required when the activity type is UNIT_TEST
$statement->module->score = new Score(); // 10:30 minutes
$statement->module->score->min = 0;
$statement->module->score->max = 100;
$statement->module->score->score = 70; // 70% student score

$statement->completed = true;
$statement->succeeded = true;

var_dump($statementClient->send($statement));
```

### Completed Statement (Module, Chapter or Unit)

The `CompletedStatement` is used to indicate that the actor (student) has completed the object (module).

```php
use Msaaq\Nelc\Common\Module;
use Msaaq\Nelc\Enums\ActivityType;
use Msaaq\Nelc\Enums\Language;
use Msaaq\Nelc\Statements\CompletedStatement;

$statement = new CompletedStatement();
$statement->language = Language::ENGLISH;
$statement->timestamp = '2022-09-14T10:33:43+03:00';

$statement->browserInformation = $browserInformation;

$statement->actor = $actor;
$statement->instructor = $instructor;

// Our parent module is the course
$statement->parent = $parent;

// Our module is the video
$statement->module = new Module();
$statement->module->url = 'https://academy.msaaq.com/courses/how-to-create-professional-course/contents/11919';
$statement->module->title = 'Unit title';
$statement->module->description = 'Unit description';
$statement->module->language = $statement->language;
$statement->module->activityType = ActivityType::MODULE;

var_dump($statementClient->send($statement));
```

### Progressed Statement

The `ProgressedStatement` is used to indicate that the actor (student) has progressed the object (module/course).

```php
use Msaaq\Nelc\Common\Module;
use Msaaq\Nelc\Enums\ActivityType;
use Msaaq\Nelc\Enums\Language;
use Msaaq\Nelc\Statements\ProgressedStatement;

$statement = new ProgressedStatement();
$statement->language = Language::ENGLISH;
$statement->timestamp = '2022-09-14T10:33:43+03:00';

$statement->actor = $actor;
$statement->instructor = $instructor;

// Our module is the course
$statement->module = new Module();
$statement->module->url = 'https://academy.msaaq.com/courses/how-to-create-professional-course';
$statement->module->title = 'How to create professional course';
$statement->module->description = 'This series will cover the most important principles of course making, marketing and content preparation.';
$statement->module->language = $statement->language;
$statement->module->activityType = ActivityType::COURSE;

$score = new \Msaaq\Nelc\Common\Score();
$score->score = 15; // the student has progressed 15% of the course

$statement->module->score = $score;

$statement->completed = false;

var_dump($statementClient->send($statement));
```

### Completed Statement (Course)

The `CompletedStatement` is used to indicate that the actor (student) has completed the object (course).

```php
use Msaaq\Nelc\Common\Module;
use Msaaq\Nelc\Enums\ActivityType;
use Msaaq\Nelc\Enums\Language;
use Msaaq\Nelc\Statements\CompletedStatement;

$statement = new CompletedStatement();
$statement->language = Language::ENGLISH;
$statement->timestamp = '2022-09-14T10:33:43+03:00';

$statement->actor = $actor;
$statement->instructor = $instructor;

// Our module is the course
$statement->module = new Module();
$statement->module->url = 'https://academy.msaaq.com/courses/how-to-create-professional-course';
$statement->module->title = 'How to create professional course';
$statement->module->description = 'This series will cover the most important principles of course making, marketing and content preparation.';
$statement->module->language = $statement->language;
$statement->module->activityType = ActivityType::COURSE;

var_dump($statementClient->send($statement));
```

### Rated Statement

The `RatedStatement` is used to indicate that the actor (student) has rated the object (course).

```php
use Msaaq\Nelc\Common\Module;
use Msaaq\Nelc\Common\Score;
use Msaaq\Nelc\Enums\ActivityType;
use Msaaq\Nelc\Enums\Language;
use Msaaq\Nelc\Statements\RatedStatement;

$statement = new RatedStatement();
$statement->language = Language::ENGLISH;
$statement->timestamp = '2022-09-14T10:33:43+03:00';

$statement->actor = $actor;
$statement->instructor = $instructor;

// The course that student rated
$statement->module = new Module();
$statement->module->url = 'https://academy.msaaq.com/courses/how-to-create-professional-course';
$statement->module->title = 'How to create professional course';
$statement->module->description = 'This series will cover the most important principles of course making, marketing and content preparation.';
$statement->module->language = $statement->language;
$statement->module->activityType = ActivityType::COURSE;

$statement->rate = new Score();
$statement->rate->min = 1;
$statement->rate->max = 5;
$statement->rate->score = 3; // 3 stars out of 5

$statement->rateContent = 'This course is very good.';

var_dump($statementClient->send($statement));
```

### Earned Statement

The `EarnedStatement` is used to indicate that the actor (student) has earned the object (certificate).

```php
use Msaaq\Nelc\Common\Module;
use Msaaq\Nelc\Common\Score;
use Msaaq\Nelc\Enums\ActivityType;
use Msaaq\Nelc\Enums\Language;
use Msaaq\Nelc\Statements\EarnedStatement;

$statement = new EarnedStatement();
$statement->language = Language::ENGLISH;
$statement->timestamp = '2022-09-14T10:33:43+03:00';

$statement->actor = $actor;
$statement->instructor = $instructor;

// The course that student earned the certificate
$statement->parent = $parent;

// The certificate that student earned
$statement->module = new Module();
$statement->module->url = 'https://academy.msaaq.com/courses/how-to-create-professional-course';
$statement->module->title = 'How to create professional course certificate';
$statement->module->description = 'This certificate is awarded to students who completed the course.';
$statement->module->language = $statement->language;
$statement->module->activityType = ActivityType::CERTIFICATE;

$statement->certificateUrl = 'path to download the certificate';

var_dump($statementClient->send($statement));
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
