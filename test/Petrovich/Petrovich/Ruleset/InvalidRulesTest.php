<?php
namespace StaticallTest\Petrovich\Petrovich\Loader;

use PHPUnit\Framework\TestCase;

use Staticall\Petrovich\Petrovich\Ruleset;
use Staticall\Petrovich\Petrovich\ValidationException;

final class InvalidRulesTest extends TestCase
{
    public function testSetInvalidRootKeyThroughConstruct() : void
    {
        $rules = $this->getRulesRoot();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    public function testSetInvalidRootKeyThroughSetter() : void
    {
        $rules = $this->getRulesRoot();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    public function testSetInvalidSecondKeyThroughConstruct() : void
    {
        $rules = $this->getRulesSecond();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    public function testSetInvalidSecondKeyThroughSetter() : void
    {
        $rules = $this->getRulesSecond();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    public function testSetInvalidValueKeyPlainThroughConstruct() : void
    {
        $rules = $this->getRulesValuePlain();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    public function testSetInvalidValueKeyPlainThroughSetter() : void
    {
        $rules = $this->getRulesValuePlain();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    public function testSetInvalidValueKeyComplexButInvalidKeyThroughConstruct() : void
    {
        $rules = $this->getRulesValueComplexButInvalidKey();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    public function testSetInvalidValueKeyComplexButInvalidKeyThroughSetter() : void
    {
        $rules = $this->getRulesValueComplexButInvalidKey();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    public function testSetInvalidValueKeyTestNotArrayThroughConstruct() : void
    {
        $rules = $this->getRulesValueTestNotArray();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    public function testSetInvalidValueKeyTestNotArrayThroughSetter() : void
    {
        $rules = $this->getRulesValueTestNotArray();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    public function testSetInvalidValueKeyModsNotArrayThroughConstruct() : void
    {
        $rules = $this->getRulesValueModsNotArray();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    public function testSetInvalidValueKeyModsNotArrayThroughSetter() : void
    {
        $rules = $this->getRulesValueModsNotArray();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    public function testSetInvalidValueKeyTagsNotArrayThroughConstruct() : void
    {
        $rules = $this->getRulesValueTagsNotArray();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    public function testSetInvalidValueKeyTagsNotArrayThroughSetter() : void
    {
        $rules = $this->getRulesValueTagsNotArray();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    public function testSetInvalidValueKeyGenderNotStringThroughConstruct() : void
    {
        $rules = $this->getRulesValueGenderNotString();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    public function testSetInvalidValueKeyGenderNotStringThroughSetter() : void
    {
        $rules = $this->getRulesValueGenderNotString();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    public function testSetInvalidValueKeyGenderInvalidThroughConstruct() : void
    {
        $rules = $this->getRulesValueGenderInvalid();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    public function testSetInvalidValueKeyGenderInvalidThroughSetter() : void
    {
        $rules = $this->getRulesValueGenderInvalid();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    public function getRulesRoot() : array
    {
        return [
            'unknownkey' => [],
        ];
    }

    public function getRulesSecond() : array
    {
        return [
            Ruleset::ROOT_KEY_FIRSTNAME => [
                'uknownSecond' => [],
            ],
        ];
    }

    public function getRulesValuePlain() : array
    {
        return [
            Ruleset::ROOT_KEY_FIRSTNAME => [
                Ruleset::SECOND_KEY_SUFFIXES => [
                    Ruleset::VALUE_KEY_TEST,
                ],
            ],
        ];
    }

    public function getRulesValueComplexButInvalidKey() : array
    {
        return [
            Ruleset::ROOT_KEY_FIRSTNAME => [
                Ruleset::SECOND_KEY_SUFFIXES => [
                    [
                        'unknownValue' => [],
                    ],
                ],
            ],
        ];
    }

    public function getRulesValueTestNotArray() : array
    {
        return [
            Ruleset::ROOT_KEY_FIRSTNAME => [
                Ruleset::SECOND_KEY_SUFFIXES => [
                    [
                        Ruleset::VALUE_KEY_TEST => 'test',
                    ],
                ],
            ],
        ];
    }

    public function getRulesValueModsNotArray() : array
    {
        return [
            Ruleset::ROOT_KEY_FIRSTNAME => [
                Ruleset::SECOND_KEY_SUFFIXES => [
                    [
                        Ruleset::VALUE_KEY_MODS => 'mods',
                    ],
                ],
            ],
        ];
    }

    public function getRulesValueTagsNotArray() : array
    {
        return [
            Ruleset::ROOT_KEY_FIRSTNAME => [
                Ruleset::SECOND_KEY_SUFFIXES => [
                    [
                        Ruleset::VALUE_KEY_TAGS => 'tags',
                    ],
                ],
            ],
        ];
    }

    public function getRulesValueGenderNotString() : array
    {
        return [
            Ruleset::ROOT_KEY_FIRSTNAME => [
                Ruleset::SECOND_KEY_SUFFIXES => [
                    [
                        Ruleset::VALUE_KEY_GENDER => [],
                    ],
                ],
            ],
        ];
    }

    public function getRulesValueGenderInvalid() : array
    {
        return [
            Ruleset::ROOT_KEY_FIRSTNAME => [
                Ruleset::SECOND_KEY_SUFFIXES => [
                    [
                        Ruleset::VALUE_KEY_GENDER => 'unknownGender',
                    ],
                ],
            ],
        ];
    }

    public function shouldExpectValidationException() : void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Input didn\'t pass validation');
    }
}
