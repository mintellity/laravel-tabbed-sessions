# Separate session for each browser tab.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mintellity/tabbed-session.svg?style=flat-square)](https://packagist.org/packages/mintellity/tabbed-session)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/mintellity/tabbed-session/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/mintellity/tabbed-session/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/mintellity/tabbed-session/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/mintellity/tabbed-session/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mintellity/tabbed-session.svg?style=flat-square)](https://packagist.org/packages/mintellity/tabbed-session)

With this package, you can have a separate session for each browser tab. This is e.g. useful if you want to have a different tenant for each tab. This package utilizes a query parameter to identify the tab and stores all data in an array within the default session.

## Installation

You can install the package via composer:

```bash
composer require mintellity/laravel-tabbed-session
```

Add the middleware to your `app/Http/Kernel.php` file. Beware that the middleware must be added after the `StartSession` middleware and must be added before all other middlewares that should use the tabbed session:

```php
protected $middleware = [
    // ...
    \Mintellity\TabbedSession\Middleware\TabbedSessionMiddleware::class,
];
```

Add the JS script to e.g. your `resources/js/app.js` file:

```js
require('../../vendor/mintellity/laravel-tabbed-session/resources/js/tabbedSession');
```

The default query parameter name is `tabId`. You can change this by editing your environment file and adding the following line. Take care that the parameter name is unique and does not conflict with other parameters in your routes. If you change the parameter name, you also have to change the name in the JS script:

```env
BROWSER_TAB_URL_PARAMETER_NAME=browserTabId
```

```js
require('../../vendor/mintellity/laravel-tabbed-session/resources/js/tabbedSession')('browserTabId');
```

## Usage

To access the tabbed session, you can use the `browsserTab()->session()` helper function:

```php
browserTab()->session()->put('foo', 'bar');
browserTab()->session()->get('foo'); // bar
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Mintellity GmbH](https://github.com/mintellity)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
