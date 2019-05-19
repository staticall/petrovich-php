<?php
namespace StaticallTest\Petrovich\Petrovich\Ruleset;

use PHPUnit\Framework\TestCase;

use Staticall\Petrovich\Petrovich\Ruleset;

class ValidateValueKeyModsTest extends TestCase
{
    public function testNoSuchKey()
    {
        $validator = new Ruleset\Validator;

        static::assertTrue($validator->validateValueKeyMods([]));
    }

    public function testRuleIsInvalidType()
    {
        $validator = new Ruleset\Validator;

        static::assertFalse(
            $validator->validateValueKeyMods(
                [
                    Ruleset::VALUE_KEY_MODS => 'test',
                ]
            )
        );
    }

    public function testRuleIsValidType()
    {
        $validator = new Ruleset\Validator;

        static::assertTrue(
            $validator->validateValueKeyMods(
                [
                    Ruleset::VALUE_KEY_MODS => [
                        'test',
                    ],
                ]
            )
        );
    }
}
