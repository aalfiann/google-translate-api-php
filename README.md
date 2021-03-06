# GoogleTranslate API PHP

[![Version](https://img.shields.io/badge/stable-1.0.1-green.svg)](https://github.com/aalfiann/google-translate-api-php)
[![Total Downloads](https://poser.pugx.org/aalfiann/google-translate-api-php/downloads)](https://packagist.org/packages/aalfiann/google-translate-api-php)
[![License](https://poser.pugx.org/aalfiann/google-translate-api-php/license)](https://github.com/aalfiann/google-translate-api-php/blob/HEAD/LICENSE.md)

A PHP class library to make your own Google Translate API for free.

## Installation

Install this package via [Composer](https://getcomposer.org/).
```
composer require "aalfiann/google-translate-api-php:^1.0"
```


## Standar Usage

```php
require_once ('vendor/autoload.php');
use \aalfiann\GoogleTranslate;

$lang = new GoogleTranslate();
$lang->source = 'id';
$lang->target = 'en';
$lang->text = 'Selamat datang di kampung halamanku!';

$result = $lang->translate()->getText();

echo $result;
```

## Chain Usage + Make detect source of language automatically

```php
require_once ('vendor/autoload.php');
use \aalfiann\GoogleTranslate;

$lang = new GoogleTranslate();
$text = 'Arigatou!';

$result = $lang->setTarget('en')->setText($text)->translate()->getText();

echo $result;
```

**Note:**  
- If you are not specify the source of language, then Google will detect it automatically.
- You should cache the results, because Google has **LIMIT RATE** and will block your IP address server if too many request.