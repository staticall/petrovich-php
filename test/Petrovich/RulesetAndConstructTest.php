<?php

namespace Masterweber\Test\Petrovich;

use Masterweber\Petrovich\Petrovich;
use PHPUnit\Framework\TestCase;

final class RulesetAndConstructTest extends TestCase
{
    /**
     * @throws Petrovich\ValidationException
     */
    public function testConstructShouldStoreRuleset(): void
    {
        $ruleset = new Petrovich\Ruleset([], false);

        $petrovich = new Petrovich($ruleset);

        RulesetAndConstructTest::assertSame($ruleset, $petrovich->getRuleset());
    }

    /**
     * @throws Petrovich\ValidationException
     */
    public function testSetterShouldStoreRuleset(): void
    {
        $rulesetConstruct = new Petrovich\Ruleset([], false);
        $rulesetSetter = new Petrovich\Ruleset([], false);

        $petrovich = new Petrovich($rulesetConstruct);

        RulesetAndConstructTest::assertNotSame($rulesetSetter, $rulesetConstruct);

        $petrovich->setRuleset($rulesetSetter);

        RulesetAndConstructTest::assertSame($rulesetSetter, $petrovich->getRuleset());
    }
}
