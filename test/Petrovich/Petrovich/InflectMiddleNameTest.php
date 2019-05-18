<?php
namespace StaticallTest\Petrovich\Petrovich;

use PHPUnit\Framework\TestCase;

use Staticall\Petrovich\Petrovich;

class InflectMiddleNameTest extends TestCase
{
    public function testMale()
    {
        $petrovich = new Petrovich(Petrovich\Loader::load(Petrovich\Loader::getVendorRulesFilePath()));

        $names = [
            'Алексеевич' => [
                Petrovich\Ruleset::CASE_NOMENATIVE    => 'Алексеевич',
                Petrovich\Ruleset::CASE_GENITIVE      => 'Алексеевича',
                Petrovich\Ruleset::CASE_DATIVE        => 'Алексеевичу',
                Petrovich\Ruleset::CASE_ACCUSATIVE    => 'Алексеевича',
                Petrovich\Ruleset::CASE_INSTRUMENTAL  => 'Алексеевичем',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Алексеевиче',
            ],

        ];

        foreach ($names as $input => $name) {
            foreach (Petrovich\Ruleset::getAvailableCases() as $case) {
                static::assertSame(
                    $name[$case],
                    $petrovich->inflectMiddleName($input, $case, Petrovich\Ruleset::GENDER_MALE),
                    'Invalid casing of "' . $input . '" for "' . $case . '" case, expecting "' . $name[$case] . '"'
                );
            }
        }
    }

    public function testFemale()
    {
        $petrovich = new Petrovich(Petrovich\Loader::load(Petrovich\Loader::getVendorRulesFilePath()));

        $names = [
            'Сергеевна' => [
                Petrovich\Ruleset::CASE_NOMENATIVE    => 'Сергеевна',
                Petrovich\Ruleset::CASE_GENITIVE      => 'Сергеевны',
                Petrovich\Ruleset::CASE_DATIVE        => 'Сергеевне',
                Petrovich\Ruleset::CASE_ACCUSATIVE    => 'Сергеевну',
                Petrovich\Ruleset::CASE_INSTRUMENTAL  => 'Сергеевной',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Сергеевне',
            ],
        ];

        foreach ($names as $input => $name) {
            foreach (Petrovich\Ruleset::getAvailableCases() as $case) {
                static::assertSame(
                    $name[$case],
                    $petrovich->inflectMiddleName($input, $case, Petrovich\Ruleset::GENDER_FEMALE),
                    'Invalid casing of "' . $input . '" for "' . $case . '" case, expecting "' . $name[$case] . '"'
                );
            }
        }
    }

    public function testAndrogynous()
    {
        $petrovich = new Petrovich(Petrovich\Loader::load(Petrovich\Loader::getVendorRulesFilePath()));

        $names = [
            'Борух' => [
                Petrovich\Ruleset::CASE_NOMENATIVE    => 'Борух',
                Petrovich\Ruleset::CASE_GENITIVE      => 'Борух',
                Petrovich\Ruleset::CASE_DATIVE        => 'Борух',
                Petrovich\Ruleset::CASE_ACCUSATIVE    => 'Борух',
                Petrovich\Ruleset::CASE_INSTRUMENTAL  => 'Борух',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Борух',
            ],
        ];

        foreach ($names as $input => $name) {
            foreach (Petrovich\Ruleset::getAvailableCases() as $case) {
                static::assertSame(
                    $name[$case],
                    $petrovich->inflectMiddleName($input, $case, Petrovich\Ruleset::GENDER_ANDROGYNOUS),
                    'Invalid casing of "' . $input . '" for "' . $case . '" case, expecting "' . $name[$case] . '"'
                );
            }
        }
    }
}
