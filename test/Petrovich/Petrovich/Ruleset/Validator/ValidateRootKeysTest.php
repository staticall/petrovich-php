<?php
namespace StaticallTest\Petrovich\Petrovich\Ruleset;

use PHPUnit\Framework\TestCase;

use Staticall\Petrovich\Petrovich\Ruleset;

class ValidateRootKeysTest extends TestCase
{
    public function testNoRootKeysFoundShouldLeadToFalse()
    {
        $rootKeys = Ruleset::getAvailableRootKeys();
        $rules    = [];

        $validator = new Ruleset\Validator();

        static::assertFalse($validator->validateRootKeys($rules));
    }

    public function testNoAvailableRootKeysFoundShouldLeadToFalse()
    {
        $rootKeys = Ruleset::getAvailableRootKeys();
        $rules    = [];

        foreach ($rootKeys as $key) {
            $rules[$key . '_'] = [];
        }

        $validator = new Ruleset\Validator();

        static::assertFalse($validator->validateRootKeys($rules));
    }

    public function testUnknownRootKeysFoundShouldLeadToFalse()
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

    public function testSingleAvailableRootKeyFoundShouldLeadToTrue()
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

    public function testAllAvailableRootKeyFoundShouldLeadToTrue()
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
