<?php

namespace Masterweber\Test\Petrovich\Petrovich\Ruleset;

use Masterweber\Petrovich\Petrovich\Ruleset;
use PHPUnit\Framework\TestCase;

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
