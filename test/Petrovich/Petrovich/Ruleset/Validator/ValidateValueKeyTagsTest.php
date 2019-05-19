<?php
namespace StaticallTest\Petrovich\Petrovich\Ruleset;

use PHPUnit\Framework\TestCase;

use Staticall\Petrovich\Petrovich\Ruleset;

class ValidateValueKeyTagsTest extends TestCase
{
    public function testNoSuchKey()
    {
        $validator = new Ruleset\Validator;

        static::assertTrue($validator->validateValueKeyTags([]));
    }

    public function testRuleIsInvalidType()
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

    public function testRuleIsValidType()
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
