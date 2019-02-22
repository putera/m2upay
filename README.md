# Maybank2U Pay - PHP SDK

This is an PHP SDK library for Maybank2U Pay

## Installation

### Composer (recommended)

Use [Composer](https://getcomposer.org) to install this library from Packagist:
[`putera/m2upay`](https://packagist.org/packages/putera/m2upay)

Run the following command from your project directory to add the dependency:

```sh
composer require putera/m2upay
```

Alternatively, add the dependency directly to your `composer.json` file:

```json
{
	"require": {
    		"putera/m2upay": "*"
	}
}
```

### Direct download

Download the [ZIP file](https://github.com/putera/m2upay/archive/master.zip)
and extract into your project. An autoloader script is provided in
`src/autoload.php` which you can require into your script. For example:

```php
require_once '/path/to/m2upay/src/autoload.php';
```

The classes in the project are structured according to the
[PSR-4](http://www.php-fig.org/psr/psr-4/) standard, so you can also use your
own autoloader or require the needed files directly in your code.

## Usage

```php
<?php

use M2U\M2UPay;

$m2upay = new M2UPay();

// Environment Type
// 0 : Sandbox
// 1 : User Acceptance Test (UAT)
// 2 : Production / Live
$envType = 0;

$mydata = array(
	'amount' => 100.00,
	'accountNumber' => "A123456",
  	'payeeCode' => "***"
);

$encryptedData = $m2upay->getEncryptionData($mydata, $envType);

```

Thanks !