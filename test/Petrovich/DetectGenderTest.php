<?php
namespace StaticallTest\Petrovich;

use PHPUnit\Framework\TestCase;

use Staticall\Petrovich;
use Staticall\Exception;

class DetectGenderTest extends TestCase
{
    public function testEmptyMiddleName()
    {
        $petrovich = new Petrovich();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Middlename cannot be empty');

        $petrovich->detectGender('');
    }

    public function testGenderless()
    {
        $middleNames = [
            'test',
            'тест',
        ];

        $petrovich = new Petrovich();

        foreach ($middleNames as $middleName) {
            static::assertSame(Petrovich::GENDER_ANDROGYNOUS, $petrovich->detectGender($middleName));
        }
    }
}