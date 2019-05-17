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

    public function shouldExpectValidationException()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Input didn\'t pass validation');
    }
}
