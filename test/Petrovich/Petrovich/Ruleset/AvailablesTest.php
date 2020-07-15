<?php
namespace StaticallTest\Petrovich\Petrovich\Ruleset;

use PHPUnit\Framework\TestCase;

use Staticall\Petrovich\Petrovich\Ruleset;

final class AvailablesTest extends TestCase
{
    public function testAvailableCasesShouldReturnCorrectAmount() : void
    {
        static::assertCount(6, Ruleset::getAvailableCases());
    }

    public function testAvailableGendersShouldReturnCorrectAmount() : void
    {
        static::assertCount(3, Ruleset::getAvailableGenders());
    }

    public function testAvailableRootKeysShouldReturnCorrectAmount() : void
    {
        static::assertCount(3, Ruleset::getAvailableRootKeys());
    }

    public function testAvailableSecondKeysShouldReturnCorrectAmount() : void
    {
        static::assertCount(2, Ruleset::getAvailableSecondKeys());
    }

    public function testAvailableValueKeysShouldReturnCorrectAmount() : void
    {
        static::assertCount(4, Ruleset::getAvailableValueKeys());
    }
}
