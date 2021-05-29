<?php

namespace Masterweber\Test\Petrovich\Petrovich\Ruleset\SingleCase;

use Masterweber\Petrovich\Petrovich\Ruleset;
use Masterweber\Petrovich\Petrovich\ValidationException;
use Masterweber\Test\Petrovich\Petrovich\Ruleset\SingleCaseHelper;

class InstrumentalFemaleTest extends SingleCaseHelper
{
    const THIS_CASE = Ruleset::CASE_INSTRUMENTAL;
    const THIS_GENDER = Ruleset::GENDER_FEMALE;

    /**
     * @throws ValidationException
     */
    public function testNoExceptionsNoSuffixes()
    {
        $this->runTestNoExceptionsNoSuffixes(
            'Тест',
            'Тест',
            static::THIS_CASE,
            static::THIS_GENDER
        );
    }

    /**
     * @throws ValidationException
     */
    public function testHasExceptionsGenderWrong1NoSuffixes()
    {
        $this->runTestHasExceptionsGenderWrong1NoSuffixes(
            'Тест',
            'Тест',
            static::THIS_CASE,
            static::THIS_GENDER
        );
    }

    /**
     * @throws ValidationException
     */
    public function testHasExceptionsGenderWrong2NoSuffixes()
    {
        $this->runTestHasExceptionsGenderWrong2NoSuffixes(
            'Тест',
            'Тест',
            static::THIS_CASE,
            static::THIS_GENDER
        );
    }

    /**
     * @throws ValidationException
     */
    public function testHasExceptionsCorrectGenderNoSuffixes()
    {
        $this->runTestHasExceptionsCorrectGenderNoSuffixes(
            'Тест',
            'Теьвом',
            static::THIS_CASE,
            static::THIS_GENDER
        );
    }

    /**
     * @throws ValidationException
     */
    public function testHasExceptionsCorrectGenderAfterIncorrectNoSuffixes()
    {
        $this->runTestHasExceptionsCorrectGenderAfterIncorrectNoSuffixes(
            'Тест',
            'Теьвом',
            static::THIS_CASE,
            static::THIS_GENDER
        );
    }

    /**
     * @throws ValidationException
     */
    public function testHasExceptionsAndSuffixes()
    {
        $this->runTestHasExceptionsAndSuffixes(
            'Тест',
            'Теьвом',
            static::THIS_CASE,
            static::THIS_GENDER
        );
    }

    /**
     * @throws ValidationException
     */
    public function testHasExceptionsAndSuffixesReverseOrder()
    {
        $this->runTestHasExceptionsAndSuffixesReverseOrder(
            'Тест',
            'Теьвом',
            static::THIS_CASE,
            static::THIS_GENDER
        );
    }

    /**
     * @throws ValidationException
     */
    public function testNoExceptionsHasSuffixes()
    {
        $this->runTestNoExceptionsHasSuffixes(
            'Тест',
            'Теьвом',
            static::THIS_CASE,
            static::THIS_GENDER
        );
    }

    /**
     * @throws ValidationException
     */
    public function testNoExceptionsHasSuffixesDotMod()
    {
        $this->runTestNoExceptionsHasSuffixesDotMod(
            'Тест',
            'Тест',
            static::THIS_CASE,
            static::THIS_GENDER
        );
    }

    /**
     * @throws ValidationException
     */
    public function testIncorrectInputShouldReturnInput()
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
