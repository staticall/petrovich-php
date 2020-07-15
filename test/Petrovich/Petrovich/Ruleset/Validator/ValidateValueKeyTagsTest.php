<?php
namespace StaticallTest\Petrovich\Petrovich\Ruleset;

use PHPUnit\Framework\TestCase;

use Staticall\Petrovich\Petrovich\Ruleset;

final class ValidateValueKeyTagsTest extends TestCase
{
    public function testNoSuchKey() : void
    {
        $validator = new Ruleset\Validator;

        static::assertTrue($validator->validateValueKeyTags([]));
    }

    public function testRuleIsInvalidType() : void
    {
        $validator = new Ruleset\Validator;

        static::assertFalse(
            $validator->validateValueKeyTags(
                [
                    Ruleset::VALUE_KEY_TAGS => 'test',
                ]
            )
        );
    }

    public function testRuleIsValidType() : void
    {
        $validator = new Ruleset\Validator;

        static::assertTrue(
            $validator->validateValueKeyTags(
                [
                    Ruleset::VALUE_KEY_TAGS => [
                        'test',
                    ],
                ]
            )
        );
    }
}
