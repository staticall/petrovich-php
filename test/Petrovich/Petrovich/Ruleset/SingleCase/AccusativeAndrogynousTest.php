<?php
namespace StaticallTest\Petrovich\Petrovich\Ruleset\SingleCase;

use StaticallTest\Petrovich\Petrovich\Ruleset\SingleCaseHelper;

use Staticall\Petrovich\Petrovich\Ruleset;

final class AccusativeAndrogynousTest extends SingleCaseHelper
{
    const THIS_CASE   = Ruleset::CASE_ACCUSATIVE;
    const THIS_GENDER = Ruleset::GENDER_ANDROGYNOUS;

    public function testNoExceptionsNoSuffixes() : void
    {
        $this->runTestNoExceptionsNoSuffixes(
            'Тест',
            'Тест',
            static::THIS_CASE,
            static::THIS_GENDER
        );
    }

    public function testHasExceptionsGenderWrong1NoSuffixes() : void
    {
        $this->runTestHasExceptionsGenderWrong1NoSuffixes(
            'Тест',
            'Тест',
            static::THIS_CASE,
            static::THIS_GENDER
        );
    }

    public function testHasExceptionsGenderWrong2NoSuffixes() : void
    {
        $this->runTestHasExceptionsGenderWrong2NoSuffixes(
            'Тест',
            'Тест',
            static::THIS_CASE,
            static::THIS_GENDER
        );
    }

    public function testHasExceptionsCorrectGenderNoSuffixes() : void
    {
        $this->runTestHasExceptionsCorrectGenderNoSuffixes(
            'Тест',
            'Теъва',
            static::THIS_CASE,
            static::THIS_GENDER
        );
    }

    public function testHasExceptionsCorrectGenderAfterIncorrectNoSuffixes() : void
    {
        $this->runTestHasExceptionsCorrectGenderAfterIncorrectNoSuffixes(
            'Тест',
            'Теъва',
            static::THIS_CASE,
            static::THIS_GENDER
        );
    }

    public function testHasExceptionsAndSuffixes() : void
    {
        $this->runTestHasExceptionsAndSuffixes(
            'Тест',
            'Теъва',
            static::THIS_CASE,
            static::THIS_GENDER
        );
    }

    public function testHasExceptionsAndSuffixesReverseOrder() : void
    {
        $this->runTestHasExceptionsAndSuffixesReverseOrder(
            'Тест',
            'Теъва',
            static::THIS_CASE,
            static::THIS_GENDER
        );
    }

    public function testNoExceptionsHasSuffixes() : void
    {
        $this->runTestNoExceptionsHasSuffixes(
            'Тест',
            'Теъва',
            static::THIS_CASE,
            static::THIS_GENDER
        );
    }

    public function testNoExceptionsHasSuffixesDotMod() : void
    {
        $this->runTestNoExceptionsHasSuffixesDotMod(
            'Тест',
            'Тест',
            static::THIS_CASE,
            static::THIS_GENDER
        );
    }

    public function testIncorrectInputShouldReturnInput() : void
    {
        $this->runTestIncorrectInputShouldReturnInput(
            'Неизвестно',
            'Тест',
            'Неизвестно',
            static::THIS_CASE,
            static::THIS_GENDER
        );
    }
}
