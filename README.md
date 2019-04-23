![Petrovich](https://raw.github.com/rocsci/petrovich/master/petrovich.png)

Склонение падежей русских имён, фамилий и отчеств.

Портированная версия с [Ruby](https://github.com/petrovich/petrovich-ruby) на PHP

Лицензия MIT

##Установка

Для работы требуется PHP >= 5.6

Загрузите файлы в папку с библиотеками на сервере.

```bash
cd lib
git clone https://github.com/staticall/petrovich-php.git petrovich-php
```

если вы хотите использовать ```petrovich``` как submodule,

```bash
git submodule add --init https://github.com/staticall/petrovich-php.git lib/petrovich-php
```

или просто скачайте исходный код со страницы проекта на Github.

##Использование

В библиотеку входит класс ```Petrovich``` и trait ```PetrovichTrait```

### Использование класса

```php
mb_internal_encoding('UTF-8');

require_once('path-to-lib/petrovich-php/src/Petrovich.php');

$petrovich = new Staticall\Petrovich(Petrovich::GENDER_MALE);

$firstname = "Александр";
$middlename = "Сергеевич";
$lastname = "Пушкин";

echo Staticall\Petrovich::detectGender("Петровна");	// Petrovich::GENDER_FEMALE (см. пункт Пол)

echo '<br /><strong>Родительный падеж:</strong><br />';
echo $petrovich->firstname($firstname, Petrovich::CASE_GENITIVE).'<br />'; //	Александра
echo $petrovich->middlename($middlename, Petrovich::CASE_GENITIVE).'<br />'; //	Сергеевича
echo $petrovich->lastname($lastname, Petrovich::CASE_GENITIVE).'<br />'; //		Пушкина
```

### Использование trait'а

Trait содержит в себе
* Свойства
  * ```firstname```
  * ```middlename```
  * ```lastname```
  * ```gender```
* Методы
  * ```firstname($case)```
  * ```middlename($case)```
  * ```lastname($case)```

```php
mb_internal_encoding('UTF-8');

require_once('path-to-lib/petrovich-php/src/Petrovich.php');
require_once('path-to-lib/petrovich-php/src/PetrovichTrait.php');

class User
{
    use Staticall\PetrovichTrait;
}

$user = new User();

$user->lastname = "Пушкин";
$user->firstname = "Александр";
$user->middlename = "Сергеевич";

$user->firstname(Petrovich::CASE_GENITIVE);	// Пушкина
$user->lastname(Petrovich::CASE_GENITIVE);	// Александра
$user->middlename(Petrovich::CASE_GENITIVE);	// Сергеевича
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
Метод ```Petrovich::detectGender``` возвращает пол, на основе отчества. Возвращаемое значение не зависит от пола, переданного в конструктор.
Для полов определены следующие константы
* GENDER_ANDROGYNOUS - пол не определен;
* GENDER_MALE - мужской пол;
* GENDER_FEMALE - женский пол.
