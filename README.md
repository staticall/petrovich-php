[![Build Status](https://secure.travis-ci.org/staticall/petrovich-php.svg?branch=master)](https://secure.travis-ci.org/staticall/petrovich-php)
[![Coverage Status](https://coveralls.io/repos/github/staticall/petrovich-php/badge.svg?branch=master)](https://coveralls.io/github/staticall/petrovich-php?branch=master)

![Petrovich](https://raw.github.com/rocsci/petrovich/master/petrovich.png)

---

#WARNING

Ведётся изменение архитектуры, использовать не рекомендуется до выхода версии 1.0.0

---

Склонение падежей русских имён, фамилий и отчеств.

Портированная версия с [Ruby](https://github.com/petrovich/petrovich-ruby) на PHP

Лицензия MIT

##Установка

Для работы требуется PHP >= 7.1.3

Загрузите файлы в папку с библиотеками на сервере.

```bash
cd lib
git clone https://github.com/staticall/petrovich-php.git petrovich-php
```

или просто скачайте исходный код со страницы проекта на Github.

##Использование

В библиотеку входит класс ```Petrovich```

### Использование класса

```php
mb_internal_encoding('UTF-8');

require_once('path-to-lib/petrovich-php/src/Petrovich.php');

$petrovich = new Staticall\Petrovich(Staticall\Petrovich\Loader::load(Staticall\Petrovich\Loader::getVendorRulesFilePath()));

$firstname  = 'Александр';
$middlename = 'Сергеевич';
$lastname   = 'Пушкин';

echo Staticall\Petrovich::detectGender('Петровна');	// Petrovich::GENDER_FEMALE (см. пункт Пол)

echo '<br /><strong>Родительный падеж:</strong><br />';
echo $petrovich->inflectFirstname($firstname, Petrovich::CASE_GENITIVE, Petrovich::GENDER_MALE).'<br />'; // Александра
echo $petrovich->inflectMiddlename($middlename, Petrovich::CASE_GENITIVE, Petrovich::GENDER_MALE).'<br />'; // Сергеевича
echo $petrovich->inflectLastname($lastname, Petrovich::CASE_GENITIVE, Petrovich::GENDER_MALE).'<br />'; // Пушкина
```

## Падежи
Названия суффиксов для методов образованы от английских названий соответствующих падежей. Полный список поддерживаемых падежей приведён в таблице ниже.

| Суффикс метода | Падеж        | Характеризующий вопрос |
|----------------|--------------|------------------------|
| CASE_NOMENATIVE| именительный | Кто? Что?            |
| CASE_GENITIVE  | родительный  | Кого? Чего?            |
| CASE_DATIVE    | дательный    | Кому? Чему?            |
| CASE_ACCUSATIVE| винительный  | Кого? Что?             |
| CASE_INSTRUMENTAL   | творительный | Кем? Чем?              |
| CASE_PREPOSITIONAL  | предложный   | О ком? О чём?          |

## Пол
Метод ```Petrovich::detectGender``` возвращает пол, на основе отчества. Поскольку нормальное определение пола возможно только через отчество, рекомендуется вручную передавать пол в каждый метод

Для полов определены следующие константы
* GENDER_ANDROGYNOUS - пол не определен;
* GENDER_MALE - мужской пол;
* GENDER_FEMALE - женский пол.
