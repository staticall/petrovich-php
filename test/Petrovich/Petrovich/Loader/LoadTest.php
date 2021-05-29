<?php

namespace Masterweber\Test\Petrovich\Petrovich\Loader;

use Masterweber\Petrovich\Petrovich\IOException;
use Masterweber\Petrovich\Petrovich\Loader;
use Masterweber\Petrovich\Petrovich\RuntimeException;
use Masterweber\Petrovich\Petrovich\ValidationException;
use PHPUnit\Framework\TestCase;

class LoadTest extends TestCase
{
    /**
     * @throws ValidationException
     * @throws IOException
     */
    public function testUnknownExtension()
    {
        $filePath = realpath(__DIR__ . '/../../../files/file.unknown');

        static::expectException(RuntimeException::class);
        static::expectExceptionMessage('File has invalid format');

        Loader::load($filePath, 'unknown');
    }

    /**
     * @throws ValidationException
     * @throws RuntimeException
     */
    public function testInvalidFile()
    {
        $filePath = realpath(__DIR__ . '/../../../files/file.not-exists');

        static::expectException(IOException::class);
        static::expectExceptionMessage('File "' . $filePath . '" doesn\'t exist or is not readable');

        Loader::load($filePath);
    }
}
