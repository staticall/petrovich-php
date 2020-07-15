<?php
namespace StaticallTest\Petrovich\Petrovich\Ruleset;

use PHPUnit\Framework\TestCase;

use Staticall\Petrovich\Petrovich\Ruleset;

final class ValidateValueKeyGenderTest extends TestCase
{
    public function testNoSuchKey() : void
    {
        $validator = new Ruleset\Validator;

        static::assertTrue($validator->validateValueKeyGender([]));
    }

    public function testRuleIsInvalidType() : void
    {
        $validator = new Ruleset\Validator;

        static::assertFalse(
            $validator->validateValueKeyGender(
                [
                    Ruleset::VALUE_KEY_GENDER => [],
                ]
            )
        );
    }

    public function testRuleIsValidValue() : void
    {
        $validator = new Ruleset\Validator;

        foreach (Ruleset::getAvailableGenders() as $gender) {
            static::assertTrue(
                $validator->validateValueKeyGender(
                    [
                        Ruleset::VALUE_KEY_GENDER => $gender,
                    ]
                )
            );
        }
    }

    public function testRuleUnknownValue() : void
    {
        $validator = new Ruleset\Validator;

        static::assertFalse(
            $validator->validateValueKeyGender(
                [
                    Ruleset::VALUE_KEY_GENDER => 'unknownGender',
                ]
            )
        );
    }
}
