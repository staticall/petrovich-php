<?php

namespace Masterweber\Test\Petrovich\Petrovich\Mutation;

use Masterweber\Petrovich\Petrovich\Ruleset;
use Masterweber\Petrovich\Petrovich\RuntimeException;
use Masterweber\Petrovich\Petrovich\ValidationException;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;

use function explode;
use function implode;

class RulesetTest extends TestCase
{
    /**
     * @throws ValidationException
     * @throws RuntimeException
     */
    public function testBreakInsteadOfContinueInInflectMethodHasSuffix()
    {
        $ruleset = new Ruleset([], false);

        $delimiter = '-';
        $name = 'Анна' . $delimiter . 'Анна';
        $gender = Ruleset::GENDER_FEMALE;

        $rules = [
            Ruleset::ROOT_KEY_FIRSTNAME => [
                Ruleset::SECOND_KEY_SUFFIXES => [
                    [
                        Ruleset::VALUE_KEY_GENDER => $gender,

                        Ruleset::VALUE_KEY_TEST => [
                            'нна',
                        ],

                        Ruleset::VALUE_KEY_MODS => [
                            '-ы',
                            '-е',
                            '-у',
                            '-ой',
                            '-е',
                        ],
                    ],
                ],
            ],
        ];

        $ruleset->setRules($rules, false);

        foreach (Ruleset::getAvailableCases() as $case) {
            $expected = [];

            foreach (explode('-', $name) as $namePart) {
                $expected[] = $ruleset->inflectFirstName($namePart, $case, $gender, $delimiter);
            }

            $expected = implode($delimiter, $expected);

            // Because nomenative case is weird
            if ($case !== Ruleset::CASE_NOMENATIVE) {
                static::assertNotSame($name, $expected);
            }

            $inflected = $ruleset->inflect($name, $case, $gender, $rules[Ruleset::ROOT_KEY_FIRSTNAME], $delimiter);

            static::assertSame($expected, $inflected);
        }
    }

    /**
     * @throws ReflectionException
     * @throws ValidationException
     */
    public function testBreakInsteadOfContinueInInflectMethodHasException()
    {
        $ruleset = new Ruleset([], false);

        $delimiter = '-';
        $name = 'Юлия' . $delimiter . 'Юлия';
        $gender = Ruleset::GENDER_FEMALE;

        $expected = [
            Ruleset::CASE_NOMENATIVE => 'Юлия' . $delimiter . 'Юлия',
            Ruleset::CASE_GENITIVE => 'Юлии' . $delimiter . 'Юлии',
            Ruleset::CASE_DATIVE => 'Юлие' . $delimiter . 'Юлие',
            Ruleset::CASE_ACCUSATIVE => 'Юлию' . $delimiter . 'Юлию',
            Ruleset::CASE_INSTRUMENTAL => 'Юлией' . $delimiter . 'Юлией',
            Ruleset::CASE_PREPOSITIONAL => 'Юлии' . $delimiter . 'Юлии',
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

            $parts = explode($delimiter, $name);

            $resultParts = [];

            foreach ($parts as $namePart) {
                // Because nomenative case is weird
                if ($case !== Ruleset::CASE_NOMENATIVE) {
                    $reflectionClass = new ReflectionClass($ruleset);

                    $getException = $reflectionClass->getMethod('getException');

                    $getException->setAccessible(true);

                    $exception = $getException->invoke(
                        $ruleset,
                        $namePart,
                        $case,
                        $gender,
                        $rules[Ruleset::ROOT_KEY_FIRSTNAME],
                        true
                    );

                    static::assertNotNull($exception);

                    $resultParts[] = $namePart;
                }
            }

            $resultName = implode($delimiter, $resultParts);

            static::assertNotSame($resultName, $toExpect);

            $inflected = $ruleset->inflect($name, $case, $gender, $rules[Ruleset::ROOT_KEY_FIRSTNAME], $delimiter);

            static::assertSame($toExpect, $inflected);
        }
    }
}
