<?php

namespace StaticallTest\Petrovich\Petrovich;

use PHPUnit\Framework\TestCase;

use Staticall\Petrovich\Petrovich;

class ParseFullNameTest extends TestCase
{
    public function testCorrectSplit()
    {
        $dataset = [
            'Тестов Тест Тестович' => [
                'lastName'   => 'Тестов',
                'firstName'  => 'Тест',
                'middleName' => 'Тестович',
            ],

            'Testov Test Testovich' => [
                'lastName'   => 'Testov',
                'firstName'  => 'Test',
                'middleName' => 'Testovich',
            ],

            'Гусев-Уткин Евграф Полиэстрович' => [
                'lastName'   => 'Гусев-Уткин',
                'firstName'  => 'Евграф',
                'middleName' => 'Полиэстрович',
            ],
        ];

        foreach ($dataset as $input => $expected) {
            static::assertSame($expected, Petrovich::parseFullName($input));
        }
    }

    public function testDoubleName()
    {
        $dataset = [
            'Фамилия Адам - Борислав Отчество' => [
                'lastName'   => 'Фамилия',
                'firstName'  => 'Адам - Борислав',
                'middleName' => 'Отчество',
            ],

            'Фамилия Иосиф-Богдан Отчество' => [
                'lastName'   => 'Фамилия',
                'firstName'  => 'Иосиф-Богдан',
                'middleName' => 'Отчество',
            ],

            'Фамилия Финнеус Уолтер Отчество' => [
                'lastName'   => 'Фамилия',
                'firstName'  => 'Финнеус Уолтер',
                'middleName' => 'Отчество',
            ],

            'Фамилия Иосиф-и-Илья Отчество' => [
                'lastName'   => 'Фамилия',
                'firstName'  => 'Иосиф-и-Илья',
                'middleName' => 'Отчество',
            ],

            'Фамилия Иосиф и Илья Отчество' => [
                'lastName'   => 'Фамилия',
                'firstName'  => 'Иосиф и Илья',
                'middleName' => 'Отчество',
            ],

            'Фамилия Иосиф+Илья Отчество' => [
                'lastName'   => 'Фамилия',
                'firstName'  => 'Иосиф+Илья',
                'middleName' => 'Отчество',
            ],

            'Фамилия Иосиф + Илья Отчество' => [
                'lastName'   => 'Фамилия',
                'firstName'  => 'Иосиф + Илья',
                'middleName' => 'Отчество',
            ],
        ];

        foreach ($dataset as $input => $expected) {
            static::assertSame($expected, Petrovich::parseFullName($input));
        }
    }

    public function testTripleNameBecausePeopleAreWeird()
    {
        $dataset = [
            'Фамилия Каспер - Валттери - Евгений Отчество' => [
                'lastName'   => 'Фамилия',
                'firstName'  => 'Каспер - Валттери - Евгений',
                'middleName' => 'Отчество',
            ],

            'Фамилия Каспер-Валттери-Евгений Отчество' => [
                'lastName'   => 'Фамилия',
                'firstName'  => 'Каспер-Валттери-Евгений',
                'middleName' => 'Отчество',
            ],

            'Фамилия Каспер Валттери Евгений Отчество' => [
                'lastName'   => 'Фамилия',
                'firstName'  => 'Каспер Валттери Евгений',
                'middleName' => 'Отчество',
            ],

            'Фамилия Каспер-и-Валттери-и-Евгений Отчество' => [
                'lastName'   => 'Фамилия',
                'firstName'  => 'Каспер-и-Валттери-и-Евгений',
                'middleName' => 'Отчество',
            ],

            'Фамилия Каспер и Валттери и Евгений Отчество' => [
                'lastName'   => 'Фамилия',
                'firstName'  => 'Каспер и Валттери и Евгений',
                'middleName' => 'Отчество',
            ],

            'Фамилия Каспер + Валттери + Евгений Отчество' => [
                'lastName'   => 'Фамилия',
                'firstName'  => 'Каспер + Валттери + Евгений',
                'middleName' => 'Отчество',
            ],

            'Фамилия Каспер+Валттери+Евгений Отчество' => [
                'lastName'   => 'Фамилия',
                'firstName'  => 'Каспер+Валттери+Евгений',
                'middleName' => 'Отчество',
            ],
        ];

        foreach ($dataset as $input => $expected) {
            static::assertSame($expected, Petrovich::parseFullName($input));
        }
    }

    public function testNoMiddleName()
    {
        $dataset = [
            'Фамилия Имя' => [
                'lastName'   => 'Фамилия',
                'firstName'  => 'Имя',
                'middleName' => null,
            ],

            'Фамилия-Фамилия2 Имя' => [
                'lastName'   => 'Фамилия-Фамилия2',
                'firstName'  => 'Имя',
                'middleName' => null,
            ],
        ];

        foreach ($dataset as $input => $expected) {
            static::assertSame($expected, Petrovich::parseFullName($input));
        }
    }

    public function testExtraMiddleName()
    {
        $dataset = [
            'Мамедов Полад Муртуза оглы' => [
                'lastName'   => 'Мамедов',
                'firstName'  => 'Полад',
                'middleName' => 'Муртуза оглы',
            ],

            'Мамедов Полад Муртуза-оглы' => [
                'lastName'   => 'Мамедов',
                'firstName'  => 'Полад',
                'middleName' => 'Муртуза-оглы',
            ],

            'Алиева Мехрибан Ариф кызы' => [
                'lastName'   => 'Алиева',
                'firstName'  => 'Мехрибан',
                'middleName' => 'Ариф кызы',
            ],

            'Алиева Мехрибан Ариф-кызы' => [
                'lastName'   => 'Алиева',
                'firstName'  => 'Мехрибан',
                'middleName' => 'Ариф-кызы',
            ],
        ];

        foreach ($dataset as $input => $expected) {
            static::assertSame($expected, Petrovich::parseFullName($input));
        }
    }
}
