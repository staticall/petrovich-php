<?php
namespace StaticallTest\Petrovich\Petrovich\Ruleset;

use PHPUnit\Framework\TestCase;

use Staticall\Petrovich\Petrovich\Ruleset;

class AvailablesTest extends TestCase
{
    public function testAvailableCasesShouldReturnCorrectAmount()
    {
        static::assertCount(6, Ruleset::getAvailableCases());
    }

    public function testAvailableGendersShouldReturnCorrectAmount()
    {
        static::assertCount(3, Ruleset::getAvailableGenders());
    }

    public function testAvailableRootKeysShouldReturnCorrectAmount()
    {
        static::assertCount(3, Ruleset::getAvailableRootKeys());
    }

    public function testAvailableSecondKeysShouldReturnCorrectAmount()
    {
        static::assertCount(2, Ruleset::getAvailableSecondKeys());
    }

    public function testAvailableValueKeysShouldReturnCorrectAmount()
    {
        static::assertCount(4, Ruleset::getAvailableValueKeys());
    }
}
