<?php
namespace StaticallTest\Petrovich\Petrovich\Ruleset;

use PHPUnit\Framework\TestCase;

use Staticall\Petrovich\Petrovich\Ruleset;

final class ValidateValueKeyTestTest extends TestCase
{
    public function testNoSuchKey() : void
    {
        $validator = new Ruleset\Validator;

        static::assertTrue($validator->validateValueKeyTest([]));
    }

    public function testRuleIsInvalidType() : void
    {
        $validator = new Ruleset\Validator;

        static::assertFalse(
            $validator->validateValueKeyTest(
                [
                    Ruleset::VALUE_KEY_TEST => 'test',
                ]
            )
        );
    }

    public function testRuleIsValidType() : void
    {
        $validator = new Ruleset\Validator;

        static::assertTrue(
            $validator->validateValueKeyTest(
                [
                    Ruleset::VALUE_KEY_TEST => [
                        'test',
                    ],
                ]
            )
        );
    }
}
