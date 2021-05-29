<?php

namespace Masterweber\Test\Petrovich\Petrovich\Loader;

use Masterweber\Petrovich\Petrovich\Loader;
use PHPUnit\Framework\TestCase;

class AvailableTest extends TestCase
{
    public function testAvailableFileTypesShouldReturnCorrectAmount()
    {
        static::assertCount(2, Loader::getAvailableFileTypes());
    }
}
