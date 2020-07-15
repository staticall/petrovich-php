<?php
namespace StaticallTest\Petrovich\Petrovich\Ruleset;

use PHPUnit\Framework\TestCase;

use Staticall\Petrovich\Petrovich\Ruleset;

final class ValidateRootKeysTest extends TestCase
{
    public function testNoRootKeysFoundShouldLeadToFalse() : void
    {
        $rules = [];

        $validator = new Ruleset\Validator();

        static::assertFalse($validator->validateRootKeys($rules));
    }

    public function testNoAvailableRootKeysFoundShouldLeadToFalse() : void
    {
        $rootKeys = Ruleset::getAvailableRootKeys();
        $rules    = [];

        foreach ($rootKeys as $key) {
            $rules[$key . '_'] = [];
        }

        $validator = new Ruleset\Validator();

        static::assertFalse($validator->validateRootKeys($rules));
    }

    public function testUnknownRootKeysFoundShouldLeadToFalse() : void
    {
        $rootKeys = Ruleset::getAvailableRootKeys();
        $rules    = [];

        foreach ($rootKeys as $key) {
            $rules[$key] = [];
            $rules[$key . '_'] = [];
        }

        $validator = new Ruleset\Validator();

        static::assertFalse($validator->validateRootKeys($rules));
    }

    public function testSingleAvailableRootKeyFoundShouldLeadToTrue() : void
    {
        $rootKeys = Ruleset::getAvailableRootKeys();
        $rules    = [];

        foreach ($rootKeys as $key) {
            $rules[$key] = [];

            break;
        }

        $validator = new Ruleset\Validator();

        static::assertTrue($validator->validateRootKeys($rules));
    }

    public function testAllAvailableRootKeyFoundShouldLeadToTrue() : void
    {
        $rootKeys = Ruleset::getAvailableRootKeys();
        $rules    = [];

        foreach ($rootKeys as $key) {
            $rules[$key] = [];
        }

        $validator = new Ruleset\Validator();

        static::assertTrue($validator->validateRootKeys($rules));
    }
}
