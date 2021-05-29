<?php

namespace Masterweber\Test\Petrovich\Petrovich;

use Masterweber\Petrovich\Petrovich;
use PHPUnit\Framework\TestCase;

final class ParseFullNameTest extends TestCase
{
    public function testCorrectSplit(): void
    {
        $dataset = [
            'Тестов Тест Тестович' => [
                'lastName' => 'Тестов',
                'firstName' => 'Тест',
                'middleName' => 'Тестович',
            ],

            'Testov Test Testovich' => [
                'lastName' => 'Testov',
                'firstName' => 'Test',
                'middleName' => 'Testovich',
            ],

            'Гусев-Уткин Евграф Полиэстрович' => [
                'lastName' => 'Гусев-Уткин',
                'firstName' => 'Евграф',
                'middleName' => 'Полиэстрович',
            ],
        ];

        foreach ($dataset as $input => $expected) {
            ParseFullNameTest::assertSame($expected, Petrovich::parseFullName($input));
        }
    }

    public function testDoubleName(): void
    {
        $dataset = [
            'Фамилия Адам - Борислав Отчество' => [
                'lastName' => 'Фамилия',
                'firstName' => 'Адам - Борислав',
                'middleName' => 'Отчество',
            ],

            'Фамилия Иосиф-Богдан Отчество' => [
                'lastName' => 'Фамилия',
                'firstName' => 'Иосиф-Богдан',
                'middleName' => 'Отчество',
            ],

            'Фамилия Финнеус Уолтер Отчество' => [
                'lastName' => 'Фамилия',
                'firstName' => 'Финнеус Уолтер',
                'middleName' => 'Отчество',
            ],

            'Фамилия Иосиф-и-Илья Отчество' => [
                'lastName' => 'Фамилия',
                'firstName' => 'Иосиф-и-Илья',
                'middleName' => 'Отчество',
            ],

            'Фамилия Иосиф и Илья Отчество' => [
                'lastName' => 'Фамилия',
                'firstName' => 'Иосиф и Илья',
                'middleName' => 'Отчество',
            ],

            'Фамилия Иосиф+Илья Отчество' => [
                'lastName' => 'Фамилия',
                'firstName' => 'Иосиф+Илья',
                'middleName' => 'Отчество',
            ],

            'Фамилия Иосиф + Илья Отчество' => [
                'lastName' => 'Фамилия',
                'firstName' => 'Иосиф + Илья',
                'middleName' => 'Отчество',
            ],
        ];

        foreach ($dataset as $input => $expected) {
            ParseFullNameTest::assertSame($expected, Petrovich::parseFullName($input));
        }
    }

    public function testTripleNameBecausePeopleAreWeird(): void
    {
        $dataset = [
            'Фамилия Каспер - Валттери - Евгений Отчество' => [
                'lastName' => 'Фамилия',
                'firstName' => 'Каспер - Валттери - Евгений',
                'middleName' => 'Отчество',
            ],

            'Фамилия Каспер-Валттери-Евгений Отчество' => [
                'lastName' => 'Фамилия',
                'firstName' => 'Каспер-Валттери-Евгений',
                'middleName' => 'Отчество',
            ],

            'Фамилия Каспер Валттери Евгений Отчество' => [
                'lastName' => 'Фамилия',
                'firstName' => 'Каспер Валттери Евгений',
                'middleName' => 'Отчество',
            ],

            'Фамилия Каспер-и-Валттери-и-Евгений Отчество' => [
                'lastName' => 'Фамилия',
                'firstName' => 'Каспер-и-Валттери-и-Евгений',
                'middleName' => 'Отчество',
            ],

            'Фамилия Каспер и Валттери и Евгений Отчество' => [
                'lastName' => 'Фамилия',
                'firstName' => 'Каспер и Валттери и Евгений',
                'middleName' => 'Отчество',
            ],

            'Фамилия Каспер + Валттери + Евгений Отчество' => [
                'lastName' => 'Фамилия',
                'firstName' => 'Каспер + Валттери + Евгений',
                'middleName' => 'Отчество',
            ],

            'Фамилия Каспер+Валттери+Евгений Отчество' => [
                'lastName' => 'Фамилия',
                'firstName' => 'Каспер+Валттери+Евгений',
                'middleName' => 'Отчество',
            ],
        ];

        foreach ($dataset as $input => $expected) {
            ParseFullNameTest::assertSame($expected, Petrovich::parseFullName($input));
        }
    }

    public function testNoMiddleName(): void
    {
        $dataset = [
            'Фамилия Имя' => [
                'lastName' => 'Фамилия',
                'firstName' => 'Имя',
                'middleName' => null,
            ],

            'Фамилия-Фамилия2 Имя' => [
                'lastName' => 'Фамилия-Фамилия2',
                'firstName' => 'Имя',
                'middleName' => null,
            ],
        ];

        foreach ($dataset as $input => $expected) {
            ParseFullNameTest::assertSame($expected, Petrovich::parseFullName($input));
        }
    }

    public function testTurkicExtraMiddleName(): void
    {
        $dataset = [
            'Мамедов Полад Муртуза ' . Petrovich::SUFFIX_TURKIC_MALE_OGLY => [
                'lastName' => 'Мамедов',
                'firstName' => 'Полад',
                'middleName' => 'Муртуза ' . Petrovich::SUFFIX_TURKIC_MALE_OGLY,
            ],

            'Мамедов Полад Муртуза-' . Petrovich::SUFFIX_TURKIC_MALE_OGLY => [
                'lastName' => 'Мамедов',
                'firstName' => 'Полад',
                'middleName' => 'Муртуза-' . Petrovich::SUFFIX_TURKIC_MALE_OGLY,
            ],

            'Алиева Мехрибан Ариф ' . Petrovich::SUFFIX_TURKIC_FEMALE_KYZY => [
                'lastName' => 'Алиева',
                'firstName' => 'Мехрибан',
                'middleName' => 'Ариф ' . Petrovich::SUFFIX_TURKIC_FEMALE_KYZY,
            ],

            'Алиева Мехрибан Ариф-' . Petrovich::SUFFIX_TURKIC_FEMALE_KYZY => [
                'lastName' => 'Алиева',
                'firstName' => 'Мехрибан',
                'middleName' => 'Ариф-' . Petrovich::SUFFIX_TURKIC_FEMALE_KYZY,
            ],
        ];

        foreach ($dataset as $input => $expected) {
            ParseFullNameTest::assertSame($expected, Petrovich::parseFullName($input));
        }
    }
}
