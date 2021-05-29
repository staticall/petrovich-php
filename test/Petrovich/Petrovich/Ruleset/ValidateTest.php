<?php

namespace Masterweber\Test\Petrovich\Petrovich\Ruleset;

use Masterweber\Petrovich\Petrovich\Ruleset;
use Masterweber\Petrovich\Petrovich\ValidationException;
use PHPUnit\Framework\TestCase;

class ValidateTest extends TestCase
{
    /**
     * @throws ValidationException
     */
    public function testOnlyAvailableRootKeys()
    {
        $ruleset = new Ruleset([], false);

        $rules = [];

        foreach (Ruleset::getAvailableRootKeys() as $availableRootKey) {
            $rules[$availableRootKey] = [];
        }

        static::assertTrue($ruleset->validate($rules));
    }

    /**
     * @throws ValidationException
     */
    public function testUnknownRootKey()
    {
        $ruleset = new Ruleset([], false);

        $rules = [
            'unknownRootKey' => [],
        ];

        static::assertFalse($ruleset->validate($rules));
    }

    /**
     * @throws ValidationException
     */
    public function testMixedBothKnownAndUnknownRootKeys()
    {
        $ruleset = new Ruleset([], false);

        $rules = [
            Ruleset::ROOT_KEY_FIRSTNAME => [],
        ];

        static::assertTrue($ruleset->validate($rules));

        $rules = [
            'unknownRootKey' => [],
        ];

        static::assertFalse($ruleset->validate($rules));

        $rules = [
            Ruleset::ROOT_KEY_FIRSTNAME => [],
            'unknownRootKey' => [],
        ];

        static::assertFalse($ruleset->validate($rules));
    }
}
