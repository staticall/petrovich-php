# Petrovich

![Petrovich](https://raw.github.com/rocsci/petrovich/master/petrovich.png)

[![Build Status](https://secure.travis-ci.org/staticall/petrovich-php.svg?branch=master)](https://secure.travis-ci.org/staticall/petrovich-php) [![Coverage Status](https://coveralls.io/repos/github/staticall/petrovich-php/badge.svg?branch=master&service=github)](https://coveralls.io/github/staticall/petrovich-php?branch=master) [![Latest Stable Version](https://poser.pugx.org/staticall/petrovich-php/v/stable)](https://packagist.org/packages/staticall/petrovich-php) [![Code Quality](https://scrutinizer-ci.com/g/staticall/petrovich-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/staticall/petrovich-php/?branch=master) [![Infection MSI](https://badge.stryker-mutator.io/github.com/staticall/petrovich-php/master)](https://infection.github.io)

Склонение падежей русских имён, фамилий и отчеств. Портированная версия с [Ruby](https://github.com/petrovich/petrovich-ruby) на PHP, использует [официальные правила](https://github.com/petrovich/petrovich-rules)

## Установка и использование

Для работы требуется PHP >= 7.1.3

Для установке, добавьте данный пакет в зависимости *Composer*, либо вручную, либо используя следующую команду:

``
composer require staticall/petrovich-php
``

### Пример использования

Пример склонения отдельно имени, фамилии и отчества:

```php
mb_internal_encoding('UTF-8');

require_once 'path-to-vendor/autoload.php';

$petrovich = new Staticall\Petrovich(Staticall\Petrovich\Loader::load('path-to-vendor/cloudloyalty/petrovich-rules/rules.json'));

// Родительный падеж
$lastNameGenitive   = $petrovich->inflectLastName('Пушкин', Staticall\Petrovich\Ruleset::CASE_GENITIVE, Staticall\Petrovich\Ruleset::GENDER_MALE); // Пушкина
$firstNameGenitive  = $petrovich->inflectFirstName('Александр', Staticall\Petrovich\Ruleset::CASE_GENITIVE, Petrovich\Ruleset::GENDER_MALE); // Александра
$middleNameGenitive = $petrovich->inflectMiddleName('Сергеевич', Staticall\Petrovich\Ruleset::CASE_GENITIVE, Staticall\Petrovich\Ruleset::GENDER_MALE); // Сергеевича
```

Пример склонения одновременно имени, фамилии и отчества:

```php
mb_internal_encoding('UTF-8');

require_once 'path-to-vendor/autoload.php';

$petrovich = new Staticall\Petrovich(Staticall\Petrovich\Loader::load('path-to-vendor/cloudloyalty/petrovich-rules/rules.json'));

// Родительный падеж
// Важно! На данный момент, такой порядок обязателен
$fullNameGenitive = $petrovich->inflectFullName('Пушкин Александр Сергеевич', Staticall\Petrovich\Ruleset::CASE_GENITIVE, Staticall\Petrovich\Ruleset::GENDER_MALE); // Пушкина Александра Сергеевича
```

Как можно определить пол по отчеству:

```php
mb_internal_encoding('UTF-8');

require_once 'path-to-vendor/autoload.php';

echo Staticall\Petrovich::detectGender('Петровна'); // Petrovich::GENDER_FEMALE
```

## Версионирование

При версионировании, следуем заветам [SemVer](http://semver.org/). Для просмотра доступных версий, взгляните на [теги этого репозитория](https://github.com/staticall/petrovich-php/tags).

## Авторы

Все [контрибьюторы оригинального проекта](https://github.com/petrovich/petrovich-php/contributors).

А также все [контрибьюторы этого форка](https://github.com/staticall/petrovich-php/contributors).

## Лицензия

Проект использует лицензию MIT - для просмотра лицензии, посмотрите файл [LICENSE.md](LICENSE.md)

## Благодарности

- [petrovich/petrovich-rules](https://github.com/petrovich/petrovich-rules)
- [cloudloyalty/petrovich-rules](https://github.com/cloudloyalty/petrovich-rules)
- [symfony/yaml](https://github.com/symfony/yaml)
- [infection/infection](https://github.com/infection/infection)
- [sebastianbergmann/phpunit](https://github.com/sebastianbergmann/phpunit)
- [squizlabs/php_codesniffer](https://github.com/squizlabs/php_codesniffer)
- [Coveralls](https://coveralls.io/)
- [Travis CI](https://travis-ci.org/)
