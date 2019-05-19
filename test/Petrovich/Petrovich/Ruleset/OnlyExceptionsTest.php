<?php
namespace StaticallTest\Petrovich\Petrovich\Ruleset;

use PHPUnit\Framework\TestCase;

use Staticall\Petrovich\Petrovich\Ruleset;

class OnlyExceptionsTest extends TestCase
{
    public function testHasNoExceptionsAndUndefined()
    {
        $ruleset = new Ruleset([], false);

        static::assertSame(
            'Тест',

            $ruleset->inflect(
                'Тест',
                Ruleset::CASE_NOMENATIVE,
                Ruleset::GENDER_ANDROGYNOUS,

                [
                ]
            )
        );
    }

    public function testHasNoExceptionsButDefined()
    {
        $ruleset = new Ruleset([], false);

        static::assertSame(
            'Тест',

            $ruleset->inflect(
                'Тест',
                Ruleset::CASE_NOMENATIVE,
                Ruleset::GENDER_ANDROGYNOUS,

                [
                    Ruleset::SECOND_KEY_EXCEPTIONS => [
                    ],
                ]
            )
        );
    }
}
