<?php

namespace Masterweber\Test\Petrovich\Petrovich\Ruleset;

use Masterweber\Petrovich\Petrovich\Ruleset;
use PHPUnit\Framework\TestCase;

class ValidateRootKeysTest extends TestCase
{
    public function testNoRootKeysFoundShouldLeadToFalse()
    {
        $rules = [];

        $validator = new Ruleset\Validator();

        static::assertFalse($validator->validateRootKeys($rules));
    }

    public function testNoAvailableRootKeysFoundShouldLeadToFalse()
    {
        $rootKeys = Ruleset::getAvailableRootKeys();
        $rules = [];

        foreach ($rootKeys as $key) {
            $rules[$key . '_'] = [];
        }

        $validator = new Ruleset\Validator();

        static::assertFalse($validator->validateRootKeys($rules));
    }

    public function testUnknownRootKeysFoundShouldLeadToFalse()
    {
        $rootKeys = Ruleset::getAvailableRootKeys();
        $rules = [];

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
        $rules = [];

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
        $rules = [];

        foreach ($rootKeys as $key) {
            $rules[$key] = [];
        }

        $validator = new Ruleset\Validator();

        static::assertTrue($validator->validateRootKeys($rules));
    }
}
