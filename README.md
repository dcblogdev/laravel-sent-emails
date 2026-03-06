## Community

There is a Discord community. https://discord.gg/VYau8hgwrm For quick help, ask questions in the appropriate channel.

# Record and view all sent emails

[![Latest Version on Packagist](https://img.shields.io/packagist/v/dcblogdev/laravel-sent-emails.svg?style=flat-square)](https://packagist.org/packages/dcblogdev/laravel-sent-emails)
[![Total Downloads](https://img.shields.io/packagist/dt/dcblogdev/laravel-sent-emails.svg?style=flat-square)](https://packagist.org/packages/dcblogdev/laravel-sent-emails)

![Example UI](https://repository-images.githubusercontent.com/279137838/610e3200-1d0e-11eb-8a39-7812708a55cd)

Watch a video walkthrough https://www.youtube.com/watch?v=Oj_OF5n4l4k&feature=youtu.be

![Sample UI](https://user-images.githubusercontent.com/1018170/107695686-d80d7c00-6ca8-11eb-8a49-c08ddfa701fb.png)

## Installation

> Note version 2+ requires Laravel 9+

You can install the package via composer:

```
composer require dcblogdev/laravel-sent-emails
```

## Migration

You can publish the migration with:

```
php artisan vendor:publish --provider="Dcblogdev\LaravelSentEmails\SentEmailsServiceProvider" --tag="migrations"
```

After the migration has been published you can the tables by running the migration:

```
php artisan migrate
```

## Config

You can publish the config with:

```
php artisan vendor:publish --provider="Dcblogdev\LaravelSentEmails\SentEmailsServiceProvider" --tag="config"
```

After the config has been published you can change the route path for sentemails from /sentemails to anything you like such as /admin/sentemails:

```
'routepath' => 'sentemails'
```

### ENV variables

```php
SENT_EMAILS_ROUTE_PATH=admin/sentemails
SENT_EMAILS_PER_PAGE=10
SENT_EMAILS_STORE_EMAILS=true
SENT_EMAILS_NO_EMAILS_MESSAGE='No emails have been sent'
SENT_EMAILS_COMPRESS_BODY=true
SENT_EMAILS_STORAGE_DISK='local'
```

## Views
You can publish the view with:

```
php artisan vendor:publish --provider="Dcblogdev\LaravelSentEmails\SentEmailsServiceProvider" --tag="views"
```

The views will be published to resources/views/vendor/sentemails

You can change the views to match your theme if desired.

## Usage

As soon as an email is sent it will be added to a database table and will be viewable in /sentemails.

> Note you have to be logged in to be able to see /sentemails, if you are not logged in when you attempt to see /sentemails you will be redirected to a login route.

### Changelog

Please see [Releases](https://github.com/dcblogdev/laravel-sent-emails/releases) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email dave@dcblog.dev instead of using the issue tracker.

## Credits

- [David Carr](https://github.com/dcblogdev)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
