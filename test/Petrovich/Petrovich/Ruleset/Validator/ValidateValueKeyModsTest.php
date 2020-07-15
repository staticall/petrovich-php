<?php
namespace StaticallTest\Petrovich\Petrovich\Ruleset;

use PHPUnit\Framework\TestCase;

use Staticall\Petrovich\Petrovich\Ruleset;

final class ValidateValueKeyModsTest extends TestCase
{
    public function testNoSuchKey() : void
    {
        $validator = new Ruleset\Validator;

        static::assertTrue($validator->validateValueKeyMods([]));
    }

    public function testRuleIsInvalidType() : void
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

    public function testRuleIsValidType() : void
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
