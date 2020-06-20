<?php
namespace StaticallTest\Petrovich;

use PHPUnit\Framework\TestCase;

use Staticall\Petrovich\Petrovich;

final class RulesetAndConstructTest extends TestCase
{
    public function testConstructShouldStoreRuleset() : void
    {
        $ruleset = new Petrovich\Ruleset([], false);

        $petrovich = new Petrovich($ruleset);

        static::assertSame($ruleset, $petrovich->getRuleset());
    }

    public function testSetterShouldStoreRuleset() : void
    {
        $rulesetConstruct = new Petrovich\Ruleset([], false);
        $rulesetSetter    = new Petrovich\Ruleset([], false);

        $petrovich = new Petrovich($rulesetConstruct);

        static::assertNotSame($rulesetSetter, $rulesetConstruct);

        $petrovich->setRuleset($rulesetSetter);

        static::assertSame($rulesetSetter, $petrovich->getRuleset());
    }
}
