# Symfony Form DateTimeImmutable Polyfill

[![GitHub license](https://img.shields.io/github/license/ruvents/ruwork-polyfill-form-dti.svg?style=flat-square)](https://github.com/ruvents/ruwork-polyfill-form-dti/blob/master/LICENSE)
[![Travis branch](https://img.shields.io/travis/ruvents/ruwork-polyfill-form-dti/master.svg?style=flat-square)](https://travis-ci.org/ruvents/ruwork-polyfill-form-dti)
[![Codecov branch](https://img.shields.io/codecov/c/github/ruvents/ruwork-polyfill-form-dti/master.svg?style=flat-square)](https://codecov.io/gh/ruvents/ruwork-polyfill-form-dti)
[![Packagist](https://img.shields.io/packagist/v/ruwork/polyfill-form-dti.svg?style=flat-square)](https://packagist.org/packages/ruwork/polyfill-form-dti)

This package is a polyfill for my [pull request](http://symfony.com/blog/new-in-symfony-4-1-added-support-for-immutable-dates-in-forms) adding `input=datetime_immutable` option to the Symfony date and time form types.

You can use it with PHP `>=5.5` and Symfony `>=2.8 <4.1`.

## Installation

```shell
composer require ruwork/polyfill-form-dti
```

## Usage

```php
<?php

use Ruwork\PolyfillFormDTI\DTIExtension;
use Ruwork\PolyfillFormDTI\Guesser\DoctrineOrmDTIGuesser;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Forms;

/** @var \Doctrine\Common\Persistence\ManagerRegistry $registry */

$factory = Forms::createFormFactoryBuilder()
    ->addExtension(new DTIExtension())
    // Optionally you can add a Doctrine ORM guesser
    // to guess input=datetime_immutable for Doctrine 2.6 immutable date types. 
    ->addTypeGuesser(new DoctrineOrmDTIGuesser($registry))
    ->getFormFactory();

$form = $factory
    ->createBuilder(FormType::class, [
        'datetime' => new \DateTimeImmutable('1828-09-09 12:00:00'),
        'date' => new \DateTimeImmutable('1860-01-29'),
        'time' => new \DateTimeImmutable('23:59'),
    ])
    ->add('datetime', DateTimeType::class, [
        'input' => 'datetime_immutable',
    ])
    ->add('date', DateType::class, [
        'input' => 'datetime_immutable',
    ])
    ->add('time', TimeType::class, [
        'input' => 'datetime_immutable',
    ])
    ->getForm();
```

## Testing

```shell
vendor/bin/simple-phpunit
```
