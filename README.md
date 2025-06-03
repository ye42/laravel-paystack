# laravel-paystack

[![Latest Stable Version](https://poser.pugx.org/ye42/laravel-paystack/v/stable.svg)](https://packagist.org/packages/ye42/laravel-paystack)
[![License](https://poser.pugx.org/ye42/laravel-paystack/license.svg)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/ye42/laravel-paystack.svg)](https://travis-ci.org/ye42/laravel-paystack)
[![Quality Score](https://img.shields.io/scrutinizer/g/ye42/laravel-paystack.svg?style=flat-square)](https://scrutinizer-ci.com/g/ye42/laravel-paystack)
[![Total Downloads](https://img.shields.io/packagist/dt/ye42/laravel-paystack.svg?style=flat-square)](https://packagist.org/packages/ye42/laravel-paystack)

> A Laravel Package for working with Paystack seamlessly

## Installation

[PHP](https://php.net) 8.2+ and [Composer](https://getcomposer.org) are required.

To get the latest version of Laravel Paystack, simply require it

```bash
composer require ye42/laravel-paystack
```

Or add the following line to the require block of your `composer.json` file.

```
"ye42/laravel-paystack": "^1.0"
```

You'll then need to run `composer install` or `composer update` to download it and have the autoloader updated.

Once Laravel Paystack is installed, you need to register the service provider. Open up `config/app.php` and add the following to the `providers` key.

```php
'providers' => [
    ...
    Ye42\Paystack\PaystackServiceProvider::class,
    ...
]
```

Also, register the Facade like so:

```php
'aliases' => [
    ...
    'Paystack' => Ye42\Paystack\Facades\Paystack::class,
    ...
]
```

## Configuration

You can publish the configuration file using this command:

```bash
php artisan vendor:publish --provider="Ye42\Paystack\PaystackServiceProvider"
```

A configuration-file named `paystack.php` with some sensible defaults will be placed in your `config` directory:

```php
<?php

return [
    /**
     * Public Key From Paystack Dashboard
     */
    'publicKey' => getenv('PAYSTACK_PUBLIC_KEY'),

    /**
     * Secret Key From Paystack Dashboard
     */
    'secretKey' => getenv('PAYSTACK_SECRET_KEY'),

    /**
     * Paystack Payment URL
     */
    'paymentUrl' => getenv('PAYSTACK_PAYMENT_URL'),

    /**
     * Optional email address of the merchant
     */
    'merchantEmail' => getenv('MERCHANT_EMAIL'),
];
```

## Usage

Open your .env file and add your public key, secret key, merchant email and payment url like so:

```php
PAYSTACK_PUBLIC_KEY=xxxxxxxxxxxxx
PAYSTACK_SECRET_KEY=xxxxxxxxxxxxx
PAYSTACK_PAYMENT_URL=https://api.paystack.co
MERCHANT_EMAIL=your-email@example.com
```

Set up routes and controller methods like so:

Note: Make sure you have `/payment/callback` registered in Paystack Dashboard [https://dashboard.paystack.co/#/settings/developer](https://dashboard.paystack.co/#/settings/developer)

```php
// Laravel 12
Route::post('/pay', [App\Http\Controllers\PaymentController::class, 'redirectToGateway'])->name('pay');
Route::get('/payment/callback', [App\Http\Controllers\PaymentController::class, 'handleGatewayCallback']);
```

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ye42\Paystack\Facades\Paystack;

class PaymentController extends Controller
{
    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway()
    {
        try {
            return Paystack::getAuthorizationUrl()->redirectNow();
        } catch (\Exception $e) {
            return Redirect::back()->withMessage(['msg' => 'The paystack token has expired. Please refresh the page and try again.', 'type' => 'error']);
        }
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();

        dd($paymentDetails);
        // Now you have the payment details,
        // you can store the authorization_code in your database to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
    }
}
```

## Features

- Easy to setup and use
- Laravel 12 compatible
- PHP 8.2+ support
- Secure payment processing
- Subscription handling
- Customer management
- Transaction verification
- Plan management
- Page management
- Subaccount management
- Bank account verification

## Security

If you discover any security related issues, please email emresural42@gmail.com instead of using the issue tracker.

## Credits

- [Original Author](https://github.com/unicodeveloper)
- [Contributors](https://github.com/ye42/laravel-paystack/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
