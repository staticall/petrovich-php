<?php
namespace StaticallTest\Petrovich;

use PHPUnit\Framework\TestCase;

use Staticall\Petrovich;
use Staticall\Exception;

class DetectGenderTest extends TestCase
{
    public function testEmptyMiddleName()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Middlename cannot be empty');

        Petrovich::detectGender('');
    }

    public function testGenderless()
    {
        $middleNames = [
            'test',
            'тест',
        ];

        foreach ($middleNames as $middleName) {
            static::assertSame(Petrovich::GENDER_ANDROGYNOUS, Petrovich::detectGender($middleName));
        }
    }
}