<?php
namespace StaticallTest\Petrovich\Petrovich\Loader;

use PHPUnit\Framework\TestCase;

use Staticall\Petrovich\Petrovich\Ruleset;
use Staticall\Petrovich\Petrovich\ValidationException;

class InvalidRulesTest extends TestCase
{
    public function testSetInvalidRootKeyThroughConstruct()
    {
        $rules = $this->getRulesRoot();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    public function testSetInvalidRootKeyThroughSetter()
    {
        $rules = $this->getRulesRoot();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    public function testSetInvalidSecondKeyThroughConstruct()
    {
        $rules = $this->getRulesSecond();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    public function testSetInvalidSecondKeyThroughSetter()
    {
        $rules = $this->getRulesSecond();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    public function testSetInvalidValueKeyPlainThroughConstruct()
    {
        $rules = $this->getRulesValuePlain();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    public function testSetInvalidValueKeyPlainThroughSetter()
    {
        $rules = $this->getRulesValuePlain();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    public function testSetInvalidValueKeyComplexButInvalidKeyThroughConstruct()
    {
        $rules = $this->getRulesValueComplexButInvalidKey();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    public function testSetInvalidValueKeyComplexButInvalidKeyThroughSetter()
    {
        $rules = $this->getRulesValueComplexButInvalidKey();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    public function testSetInvalidValueKeyTestNotArrayThroughConstruct()
    {
        $rules = $this->getRulesValueTestNotArray();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    public function testSetInvalidValueKeyTestNotArrayThroughSetter()
    {
        $rules = $this->getRulesValueTestNotArray();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    public function testSetInvalidValueKeyModsNotArrayThroughConstruct()
    {
        $rules = $this->getRulesValueModsNotArray();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    public function testSetInvalidValueKeyModsNotArrayThroughSetter()
    {
        $rules = $this->getRulesValueModsNotArray();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    public function testSetInvalidValueKeyTagsNotArrayThroughConstruct()
    {
        $rules = $this->getRulesValueTagsNotArray();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    public function testSetInvalidValueKeyTagsNotArrayThroughSetter()
    {
        $rules = $this->getRulesValueTagsNotArray();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    public function testSetInvalidValueKeyGenderNotStringThroughConstruct()
    {
        $rules = $this->getRulesValueGenderNotString();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    public function testSetInvalidValueKeyGenderNotStringThroughSetter()
    {
        $rules = $this->getRulesValueGenderNotString();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    public function testSetInvalidValueKeyGenderInvalidThroughConstruct()
    {
        $rules = $this->getRulesValueGenderInvalid();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    public function testSetInvalidValueKeyGenderInvalidThroughSetter()
    {
        $rules = $this->getRulesValueGenderInvalid();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    public function getRulesRoot()
    {
        return [
            'unknownkey' => [],
        ];
    }

    public function getRulesSecond()
    {
        return [
            Ruleset::ROOT_KEY_FIRSTNAME => [
                'uknownSecond' => [],
            ],
        ];
    }

    public function getRulesValuePlain()
    {
        return [
            Ruleset::ROOT_KEY_FIRSTNAME => [
                Ruleset::SECOND_KEY_SUFFIXES => [
                    Ruleset::VALUE_KEY_TEST,
                ],
            ],
        ];
    }

    public function getRulesValueComplexButInvalidKey()
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

    public function getRulesValueTestNotArray()
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

    public function getRulesValueModsNotArray()
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

    public function getRulesValueTagsNotArray()
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

    public function getRulesValueGenderNotString()
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

    public function getRulesValueGenderInvalid()
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

    public function shouldExpectValidationException()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Input didn\'t pass validation');
    }
}
