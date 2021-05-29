<?php

namespace Masterweber\Test\Petrovich\Petrovich\Ruleset;

use Masterweber\Petrovich\Petrovich\Ruleset;
use Masterweber\Petrovich\Petrovich\ValidationException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;

class OnlyExceptionsTest extends TestCase
{
    /**
     * @throws ValidationException
     */
    public function testHasNoExceptionsAndUndefined()
    {
        $ruleset = new Ruleset([], false);

        static::assertSame(
            'Тест',

            $ruleset->inflect(
                'Тест',
                Ruleset::CASE_NOMENATIVE,
                Ruleset::GENDER_ANDROGYNOUS,

                [
                ]
            )
        );
    }

    /**
     * @throws ValidationException
     */
    public function testHasNoExceptionsButDefined()
    {
        $ruleset = new Ruleset([], false);

        static::assertSame(
            'Тест',

            $ruleset->inflect(
                'Тест',
                Ruleset::CASE_NOMENATIVE,
                Ruleset::GENDER_ANDROGYNOUS,

                [
                    Ruleset::SECOND_KEY_EXCEPTIONS => [
                    ],
                ]
            )
        );
    }

    /**
     * @throws ValidationException
     * @throws ReflectionException
     */
    public function testExceptionShouldOnlyRunOnSecond()
    {
        $ruleset = new Ruleset([], false);

        $name = 'Юлия';
        $gender = Ruleset::GENDER_FEMALE;

        $expected = [
            Ruleset::CASE_NOMENATIVE => 'Юлия',
            Ruleset::CASE_GENITIVE => 'Юлии',
            Ruleset::CASE_DATIVE => 'Юлие',
            Ruleset::CASE_ACCUSATIVE => 'Юлию',
            Ruleset::CASE_INSTRUMENTAL => 'Юлией',
            Ruleset::CASE_PREPOSITIONAL => 'Юлии',
        ];

        $rules = [
            Ruleset::ROOT_KEY_FIRSTNAME => [
                Ruleset::SECOND_KEY_EXCEPTIONS => [
                    [
                        Ruleset::VALUE_KEY_GENDER => $gender,

                        Ruleset::VALUE_KEY_TEST => [
                            'анна',
                        ],

                        Ruleset::VALUE_KEY_MODS => [
                            '-ы',
                            '-е',
                            '-у',
                            '-ой',
                            '-е',
                        ],
                    ],

                    [
                        Ruleset::VALUE_KEY_GENDER => $gender,

                        Ruleset::VALUE_KEY_TEST => [
                            'юлия',
                        ],

                        Ruleset::VALUE_KEY_MODS => [
                            '-и',
                            '-е',
                            '-ю',
                            '-ей',
                            '-и',
                        ],
                    ],
                ],
            ],
        ];

        $ruleset->setRules($rules, false);

        foreach (Ruleset::getAvailableCases() as $case) {
            $toExpect = $expected[$case];

            // Because nomenative case is weird
            if ($case !== Ruleset::CASE_NOMENATIVE) {
                $reflectionClass = new ReflectionClass($ruleset);

                $getException = $reflectionClass->getMethod('getException');

                $getException->setAccessible(true);

                $exception = $getException->invoke(
                    $ruleset,
                    $name,
                    $case,
                    $gender,
                    $rules[Ruleset::ROOT_KEY_FIRSTNAME]
                );

                static::assertNotNull($exception);

                static::assertNotSame($name, $toExpect);
            }

            $inflected = $ruleset->inflect($name, $case, $gender, $rules[Ruleset::ROOT_KEY_FIRSTNAME]);

            static::assertSame($toExpect, $inflected);
        }
    }
}
