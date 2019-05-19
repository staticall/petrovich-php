<?php
namespace StaticallTest\Petrovich\Petrovich\Mutation;

use PHPUnit\Framework\TestCase;

use Staticall\Petrovich\Petrovich\Ruleset;

class RulesetTest extends TestCase
{
    public function testBreakInsteadOfContinueInInflectMethod()
    {
        $ruleset = new Ruleset([], false);

        $delimiter = '-';
        $name      = 'Анна' . $delimiter . 'Анна';
        $gender    = Ruleset::GENDER_FEMALE;

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
            ]
        ];

        $ruleset->setRules($rules, false);

        foreach (Ruleset::getAvailableCases() as $case) {
            $expected = [];

            foreach (\explode('-', $name) as $namePart) {
                $expected[] = $ruleset->inflectFirstName($namePart, $case, $gender, $delimiter);
            }

            $expected = \implode($delimiter, $expected);

            // Because nomenative case is weird
            if ($case !== Ruleset::CASE_NOMENATIVE) {
                static::assertNotSame($name, $expected);
            }

            $inflected = $ruleset->inflect($name, $case, $gender, $rules[Ruleset::ROOT_KEY_FIRSTNAME], $delimiter);

            static::assertSame($expected, $inflected);
        }
    }
}
