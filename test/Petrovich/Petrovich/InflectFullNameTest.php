<?php
namespace StaticallTest\Petrovich\Petrovich;

use PHPUnit\Framework\TestCase;

use Staticall\Petrovich\Petrovich;

class InflectFullNameTest extends TestCase
{
    public function testWithoutMiddleNameRules()
    {
        $ruleset = Petrovich\Loader::load(Petrovich\Loader::getVendorRulesFilePath());

        $rules = $ruleset->getRules();

        unset($rules[Petrovich\Ruleset::ROOT_KEY_MIDDLENAME]);

        $ruleset->setRules($rules, false);

        $petrovich = new Petrovich($ruleset);

        $name = 'Барбарисов Сигизмунд Петрович';

        $this->expectException(Petrovich\RuntimeException::class);
        $this->expectExceptionMessage('Missing key "' . Petrovich\Ruleset::ROOT_KEY_MIDDLENAME . '" for inflection');

        $petrovich->inflectFullName($name, Petrovich\Ruleset::CASE_NOMENATIVE, Petrovich\Ruleset::GENDER_MALE);
    }

    public function testWithoutFirstNameRules()
    {
        $ruleset = Petrovich\Loader::load(Petrovich\Loader::getVendorRulesFilePath());

        $rules = $ruleset->getRules();

        unset($rules[Petrovich\Ruleset::ROOT_KEY_FIRSTNAME]);

        $ruleset->setRules($rules, false);

        $petrovich = new Petrovich($ruleset);

        $name = 'Барбарисов Сигизмунд Петрович';

        $this->expectException(Petrovich\RuntimeException::class);
        $this->expectExceptionMessage('Missing key "' . Petrovich\Ruleset::ROOT_KEY_FIRSTNAME . '" for inflection');

        $petrovich->inflectFullName($name, Petrovich\Ruleset::CASE_NOMENATIVE, Petrovich\Ruleset::GENDER_MALE);
    }

    public function testWithoutLastNameRules()
    {
        $ruleset = Petrovich\Loader::load(Petrovich\Loader::getVendorRulesFilePath());

        $rules = $ruleset->getRules();

        unset($rules[Petrovich\Ruleset::ROOT_KEY_LASTNAME]);

        $ruleset->setRules($rules, false);

        $petrovich = new Petrovich($ruleset);

        $name = 'Барбарисов Сигизмунд Петрович';

        $this->expectException(Petrovich\RuntimeException::class);
        $this->expectExceptionMessage('Missing key "' . Petrovich\Ruleset::ROOT_KEY_LASTNAME . '" for inflection');

        $petrovich->inflectFullName($name, Petrovich\Ruleset::CASE_NOMENATIVE, Petrovich\Ruleset::GENDER_MALE);
    }

    public function testMale()
    {
        $petrovich = new Petrovich(Petrovich\Loader::load(Petrovich\Loader::getVendorRulesFilePath()));

        $names = [
            'Петров Полиграф Афанасьевич' => [
                Petrovich\Ruleset::CASE_NOMENATIVE    => 'Петров Полиграф Афанасьевич',
                Petrovich\Ruleset::CASE_GENITIVE      => 'Петрова Полиграфа Афанасьевича',
                Petrovich\Ruleset::CASE_DATIVE        => 'Петрову Полиграфу Афанасьевичу',
                Petrovich\Ruleset::CASE_ACCUSATIVE    => 'Петрова Полиграфа Афанасьевича',
                Petrovich\Ruleset::CASE_INSTRUMENTAL  => 'Петровым Полиграфом Афанасьевичем',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Петрове Полиграфе Афанасьевиче',
            ],
        ];

        foreach ($names as $input => $name) {
            foreach (Petrovich\Ruleset::getAvailableCases() as $case) {
                static::assertSame(
                    $name[$case],
                    $petrovich->inflectFullName($input, $case, Petrovich\Ruleset::GENDER_MALE),
                    'Invalid casing of "' . $input . '" for "' . $case . '" case, expecting "' . $name[$case] . '"'
                );
            }
        }
    }

    public function testFemale()
    {
        $petrovich = new Petrovich(Petrovich\Loader::load(Petrovich\Loader::getVendorRulesFilePath()));

        $names = [
            'Петрова Анна Юрьевна' => [
                Petrovich\Ruleset::CASE_NOMENATIVE    => 'Петрова Анна Юрьевна',
                Petrovich\Ruleset::CASE_GENITIVE      => 'Петровой Анны Юрьевны',
                Petrovich\Ruleset::CASE_DATIVE        => 'Петровой Анне Юрьевне',
                Petrovich\Ruleset::CASE_ACCUSATIVE    => 'Петрову Анну Юрьевну',
                Petrovich\Ruleset::CASE_INSTRUMENTAL  => 'Петровой Анной Юрьевной',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Петровой Анне Юрьевне',
            ],
        ];

        foreach ($names as $input => $name) {
            foreach (Petrovich\Ruleset::getAvailableCases() as $case) {
                static::assertSame(
                    $name[$case],
                    $petrovich->inflectFullName($input, $case, Petrovich\Ruleset::GENDER_FEMALE),
                    'Invalid casing of "' . $input . '" for "' . $case . '" case, expecting "' . $name[$case] . '"'
                );
            }
        }
    }

    public function testWithDetectGender()
    {
        $petrovich = new Petrovich(Petrovich\Loader::load(Petrovich\Loader::getVendorRulesFilePath()));

        $names = [
            'Петров Полиграф Афанасьевич' => [
                Petrovich\Ruleset::CASE_NOMENATIVE    => 'Петров Полиграф Афанасьевич',
                Petrovich\Ruleset::CASE_GENITIVE      => 'Петрова Полиграфа Афанасьевича',
                Petrovich\Ruleset::CASE_DATIVE        => 'Петрову Полиграфу Афанасьевичу',
                Petrovich\Ruleset::CASE_ACCUSATIVE    => 'Петрова Полиграфа Афанасьевича',
                Petrovich\Ruleset::CASE_INSTRUMENTAL  => 'Петровым Полиграфом Афанасьевичем',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Петрове Полиграфе Афанасьевиче',
            ],

            'Петрова Анна Юрьевна' => [
                Petrovich\Ruleset::CASE_NOMENATIVE    => 'Петрова Анна Юрьевна',
                Petrovich\Ruleset::CASE_GENITIVE      => 'Петровой Анны Юрьевны',
                Petrovich\Ruleset::CASE_DATIVE        => 'Петровой Анне Юрьевне',
                Petrovich\Ruleset::CASE_ACCUSATIVE    => 'Петрову Анну Юрьевну',
                Petrovich\Ruleset::CASE_INSTRUMENTAL  => 'Петровой Анной Юрьевной',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Петровой Анне Юрьевне',
            ],
        ];

        foreach ($names as $input => $name) {
            foreach (Petrovich\Ruleset::getAvailableCases() as $case) {
                static::assertSame(
                    $name[$case],
                    $petrovich->inflectFullName($input, $case),
                    'Invalid casing of "' . $input . '" for "' . $case . '" case, expecting "' . $name[$case] . '"'
                );
            }
        }
    }
}
