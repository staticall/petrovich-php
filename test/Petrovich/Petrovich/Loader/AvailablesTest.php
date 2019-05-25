<?php
namespace StaticallTest\Petrovich\Petrovich\Loader;

use PHPUnit\Framework\TestCase;

use Staticall\Petrovich\Petrovich\Loader;

class AvailablesTest extends TestCase
{
    public function testAvailableFileTypesShouldReturnCorrectAmount()
    {
        static::assertCount(2, Loader::getAvailableFileTypes());
    }
}
