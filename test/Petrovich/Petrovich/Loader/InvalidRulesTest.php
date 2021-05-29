<?php

namespace Masterweber\Test\Petrovich\Petrovich\Loader;

use JetBrains\PhpStorm\ArrayShape;
use Masterweber\Petrovich\Petrovich\Ruleset;
use Masterweber\Petrovich\Petrovich\ValidationException;
use PHPUnit\Framework\TestCase;

class InvalidRulesTest extends TestCase
{
    /**
     * @throws ValidationException
     */
    public function testSetInvalidRootKeyThroughConstruct()
    {
        $rules = $this->getRulesRoot();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    /**
     * @throws ValidationException
     */
    public function testSetInvalidRootKeyThroughSetter()
    {
        $rules = $this->getRulesRoot();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    /**
     * @throws ValidationException
     */
    public function testSetInvalidSecondKeyThroughConstruct()
    {
        $rules = $this->getRulesSecond();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    /**
     * @throws ValidationException
     */
    public function testSetInvalidSecondKeyThroughSetter()
    {
        $rules = $this->getRulesSecond();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    /**
     * @throws ValidationException
     */
    public function testSetInvalidValueKeyPlainThroughConstruct()
    {
        $rules = $this->getRulesValuePlain();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    /**
     * @throws ValidationException
     */
    public function testSetInvalidValueKeyPlainThroughSetter()
    {
        $rules = $this->getRulesValuePlain();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    /**
     * @throws ValidationException
     */
    public function testSetInvalidValueKeyComplexButInvalidKeyThroughConstruct()
    {
        $rules = $this->getRulesValueComplexButInvalidKey();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    /**
     * @throws ValidationException
     */
    public function testSetInvalidValueKeyComplexButInvalidKeyThroughSetter()
    {
        $rules = $this->getRulesValueComplexButInvalidKey();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    /**
     * @throws ValidationException
     */
    public function testSetInvalidValueKeyTestNotArrayThroughConstruct()
    {
        $rules = $this->getRulesValueTestNotArray();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    /**
     * @throws ValidationException
     */
    public function testSetInvalidValueKeyTestNotArrayThroughSetter()
    {
        $rules = $this->getRulesValueTestNotArray();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    /**
     * @throws ValidationException
     */
    public function testSetInvalidValueKeyModsNotArrayThroughConstruct()
    {
        $rules = $this->getRulesValueModsNotArray();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    /**
     * @throws ValidationException
     */
    public function testSetInvalidValueKeyModsNotArrayThroughSetter()
    {
        $rules = $this->getRulesValueModsNotArray();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    /**
     * @throws ValidationException
     */
    public function testSetInvalidValueKeyTagsNotArrayThroughConstruct()
    {
        $rules = $this->getRulesValueTagsNotArray();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    /**
     * @throws ValidationException
     */
    public function testSetInvalidValueKeyTagsNotArrayThroughSetter()
    {
        $rules = $this->getRulesValueTagsNotArray();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    /**
     * @throws ValidationException
     */
    public function testSetInvalidValueKeyGenderNotStringThroughConstruct()
    {
        $rules = $this->getRulesValueGenderNotString();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    /**
     * @throws ValidationException
     */
    public function testSetInvalidValueKeyGenderNotStringThroughSetter()
    {
        $rules = $this->getRulesValueGenderNotString();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    /**
     * @throws ValidationException
     */
    public function testSetInvalidValueKeyGenderInvalidThroughConstruct()
    {
        $rules = $this->getRulesValueGenderInvalid();

        $this->shouldExpectValidationException();

        new Ruleset($rules, true);
    }

    /**
     * @throws ValidationException
     */
    public function testSetInvalidValueKeyGenderInvalidThroughSetter()
    {
        $rules = $this->getRulesValueGenderInvalid();

        $this->shouldExpectValidationException();

        $ruleset = new Ruleset([], false);

        $ruleset->setRules($rules, true);
    }

    #[ArrayShape(['unknownkey' => 'array'])]
    public function getRulesRoot(): array
    {
        return [
            'unknownkey' => [],
        ];
    }

    #[ArrayShape([Ruleset::ROOT_KEY_FIRSTNAME => 'array[]'])]
    public function getRulesSecond(): array
    {
        return [
            Ruleset::ROOT_KEY_FIRSTNAME => [
                'uknownSecond' => [],
            ],
        ];
    }

    #[ArrayShape([Ruleset::ROOT_KEY_FIRSTNAME => 'array[]'])]
    public function getRulesValuePlain(): array
    {
        return [
            Ruleset::ROOT_KEY_FIRSTNAME => [
                Ruleset::SECOND_KEY_SUFFIXES => [
                    Ruleset::VALUE_KEY_TEST,
                ],
            ],
        ];
    }

    #[ArrayShape([Ruleset::ROOT_KEY_FIRSTNAME => '\array[][][]'])]
    public function getRulesValueComplexButInvalidKey(): array
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

    #[ArrayShape([Ruleset::ROOT_KEY_FIRSTNAME => '\string[][][]'])]
    public function getRulesValueTestNotArray(): array
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

    #[ArrayShape([Ruleset::ROOT_KEY_FIRSTNAME => '\string[][][]'])]
    public function getRulesValueModsNotArray(): array
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

    #[ArrayShape([Ruleset::ROOT_KEY_FIRSTNAME => '\string[][][]'])]
    public function getRulesValueTagsNotArray(): array
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

    #[ArrayShape([Ruleset::ROOT_KEY_FIRSTNAME => '\array[][][]'])]
    public function getRulesValueGenderNotString(): array
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

    #[ArrayShape([Ruleset::ROOT_KEY_FIRSTNAME => '\string[][][]'])]
    public function getRulesValueGenderInvalid(): array
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
