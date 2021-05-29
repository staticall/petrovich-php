<?php

namespace Masterweber\Test\Petrovich\Petrovich;

use Masterweber\Petrovich\Petrovich;
use PHPUnit\Framework\TestCase;

class InflectLastNameTest extends TestCase
{
    /**
     * @throws Petrovich\IOException
     * @throws Petrovich\ValidationException
     * @throws Petrovich\RuntimeException
     */
    public function testWithoutLastNameRules()
    {
        $ruleset = Petrovich\Loader::load(Petrovich\Loader::getVendorRulesFilePath());

        $rules = $ruleset->getRules();

        unset($rules[Petrovich\Ruleset::ROOT_KEY_LASTNAME]);

        $ruleset->setRules($rules, false);

        $petrovich = new Petrovich($ruleset);

        $name = 'Боровинский';

        $this->expectException(Petrovich\RuntimeException::class);
        $this->expectExceptionMessage('Missing key "' . Petrovich\Ruleset::ROOT_KEY_LASTNAME . '" for inflection');

        $petrovich->inflectLastName($name, Petrovich\Ruleset::CASE_NOMENATIVE, Petrovich\Ruleset::GENDER_MALE);
    }

    /**
     * @throws Petrovich\ValidationException
     * @throws Petrovich\IOException
     * @throws Petrovich\RuntimeException
     */
    public function testMale()
    {
        $petrovich = new Petrovich(Petrovich\Loader::load(Petrovich\Loader::getVendorRulesFilePath()));

        $names = [
            'Колесников' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Колесников',
                Petrovich\Ruleset::CASE_GENITIVE => 'Колесникова',
                Petrovich\Ruleset::CASE_DATIVE => 'Колесникову',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Колесникова',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Колесниковым',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Колесникове',
            ],

            'Шульц' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Шульц',
                Petrovich\Ruleset::CASE_GENITIVE => 'Шульца',
                Petrovich\Ruleset::CASE_DATIVE => 'Шульцу',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Шульца',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Шульцем',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Шульце',
            ],

            'Болл' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Болл',
                Petrovich\Ruleset::CASE_GENITIVE => 'Болла',
                Petrovich\Ruleset::CASE_DATIVE => 'Боллу',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Болла',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Боллом',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Болле',
            ],

            'Белоконь' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Белоконь',
                Petrovich\Ruleset::CASE_GENITIVE => 'Белоконя',
                Petrovich\Ruleset::CASE_DATIVE => 'Белоконю',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Белоконя',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Белоконем',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Белоконе',
            ],
        ];

        foreach ($names as $input => $name) {
            foreach (Petrovich\Ruleset::getAvailableCases() as $case) {
                static::assertSame(
                    $name[$case],
                    $petrovich->inflectLastName($input, $case, Petrovich\Ruleset::GENDER_MALE),
                    'Invalid casing of "' . $input . '" for "' . $case . '" case, expecting "' . $name[$case] . '"'
                );
            }
        }
    }

    /**
     * @throws Petrovich\ValidationException
     * @throws Petrovich\IOException
     * @throws Petrovich\RuntimeException
     */
    public function testFemale()
    {
        $petrovich = new Petrovich(Petrovich\Loader::load(Petrovich\Loader::getVendorRulesFilePath()));

        $names = [
            'Колесникова' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Колесникова',
                Petrovich\Ruleset::CASE_GENITIVE => 'Колесниковой',
                Petrovich\Ruleset::CASE_DATIVE => 'Колесниковой',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Колесникову',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Колесниковой',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Колесниковой',
            ],
        ];

        foreach ($names as $input => $name) {
            foreach (Petrovich\Ruleset::getAvailableCases() as $case) {
                static::assertSame(
                    $name[$case],
                    $petrovich->inflectLastName($input, $case, Petrovich\Ruleset::GENDER_FEMALE),
                    'Invalid casing of "' . $input . '" for "' . $case . '" case, expecting "' . $name[$case] . '"'
                );
            }
        }
    }

    /**
     * @throws Petrovich\ValidationException
     * @throws Petrovich\IOException
     * @throws Petrovich\RuntimeException
     */
    public function testAndrogynous()
    {
        $petrovich = new Petrovich(Petrovich\Loader::load(Petrovich\Loader::getVendorRulesFilePath()));

        $names = [
            'Фидря' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Фидря',
                Petrovich\Ruleset::CASE_GENITIVE => 'Фидри',
                Petrovich\Ruleset::CASE_DATIVE => 'Фидре',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Фидрю',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Фидрей',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Фидре',
            ],
        ];

        foreach ($names as $input => $name) {
            foreach (Petrovich\Ruleset::getAvailableCases() as $case) {
                static::assertSame(
                    $name[$case],
                    $petrovich->inflectLastName($input, $case, Petrovich\Ruleset::GENDER_ANDROGYNOUS),
                    'Invalid casing of "' . $input . '" for "' . $case . '" case, expecting "' . $name[$case] . '"'
                );
            }
        }
    }
}
