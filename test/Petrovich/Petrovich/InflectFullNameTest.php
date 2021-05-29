<?php

namespace Masterweber\Test\Petrovich\Petrovich;

use Masterweber\Petrovich\Exception;
use Masterweber\Petrovich\Petrovich;
use PHPUnit\Framework\TestCase;

class InflectFullNameTest extends TestCase
{
    /**
     * @throws Petrovich\ValidationException
     * @throws Petrovich\IOException
     * @throws Exception
     * @throws Petrovich\RuntimeException
     */
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

    /**
     * @throws Petrovich\ValidationException
     * @throws Petrovich\IOException
     * @throws Exception
     * @throws Petrovich\RuntimeException
     */
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

    /**
     * @throws Petrovich\IOException
     * @throws Petrovich\ValidationException
     * @throws Exception
     * @throws Petrovich\RuntimeException
     */
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

    /**
     * @throws Petrovich\ValidationException
     * @throws Petrovich\IOException
     * @throws Exception
     * @throws Petrovich\RuntimeException
     */
    public function testMale()
    {
        $petrovich = new Petrovich(Petrovich\Loader::load(Petrovich\Loader::getVendorRulesFilePath()));

        $names = [
            'Петров Полиграф Афанасьевич' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Петров Полиграф Афанасьевич',
                Petrovich\Ruleset::CASE_GENITIVE => 'Петрова Полиграфа Афанасьевича',
                Petrovich\Ruleset::CASE_DATIVE => 'Петрову Полиграфу Афанасьевичу',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Петрова Полиграфа Афанасьевича',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Петровым Полиграфом Афанасьевичем',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Петрове Полиграфе Афанасьевиче',
            ],

            'Петров Полиграф' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Петров Полиграф',
                Petrovich\Ruleset::CASE_GENITIVE => 'Петрова Полиграфа',
                Petrovich\Ruleset::CASE_DATIVE => 'Петрову Полиграфу',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Петрова Полиграфа',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Петровым Полиграфом',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Петрове Полиграфе',
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

    /**
     * @throws Petrovich\IOException
     * @throws Petrovich\ValidationException
     * @throws Exception
     * @throws Petrovich\RuntimeException
     */
    public function testFemale()
    {
        $petrovich = new Petrovich(Petrovich\Loader::load(Petrovich\Loader::getVendorRulesFilePath()));

        $names = [
            'Петрова Анна Юрьевна' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Петрова Анна Юрьевна',
                Petrovich\Ruleset::CASE_GENITIVE => 'Петровой Анны Юрьевны',
                Petrovich\Ruleset::CASE_DATIVE => 'Петровой Анне Юрьевне',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Петрову Анну Юрьевну',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Петровой Анной Юрьевной',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Петровой Анне Юрьевне',
            ],

            'Петрова Анна' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Петрова Анна',
                Petrovich\Ruleset::CASE_GENITIVE => 'Петровой Анны',
                Petrovich\Ruleset::CASE_DATIVE => 'Петровой Анне',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Петрову Анну',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Петровой Анной',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Петровой Анне',
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

    /**
     * @throws Petrovich\ValidationException
     * @throws Petrovich\IOException
     * @throws Exception
     * @throws Petrovich\RuntimeException
     */
    public function testWithDetectGender()
    {
        $petrovich = new Petrovich(Petrovich\Loader::load(Petrovich\Loader::getVendorRulesFilePath()));

        $names = [
            'Петров Полиграф Афанасьевич' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Петров Полиграф Афанасьевич',
                Petrovich\Ruleset::CASE_GENITIVE => 'Петрова Полиграфа Афанасьевича',
                Petrovich\Ruleset::CASE_DATIVE => 'Петрову Полиграфу Афанасьевичу',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Петрова Полиграфа Афанасьевича',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Петровым Полиграфом Афанасьевичем',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Петрове Полиграфе Афанасьевиче',
            ],

            'Петрова Анна Юрьевна' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Петрова Анна Юрьевна',
                Petrovich\Ruleset::CASE_GENITIVE => 'Петровой Анны Юрьевны',
                Petrovich\Ruleset::CASE_DATIVE => 'Петровой Анне Юрьевне',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Петрову Анну Юрьевну',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Петровой Анной Юрьевной',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Петровой Анне Юрьевне',
            ],

            // Cases are weird, because no gender AND no middle name provided, hence it's assumed, that gender = GENDER_ANDROGYNOUS
            'Петров Полиграф' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Петров Полиграф',
                Petrovich\Ruleset::CASE_GENITIVE => 'Петров Полиграф',
                Petrovich\Ruleset::CASE_DATIVE => 'Петров Полиграф',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Петров Полиграф',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Петров Полиграф',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Петров Полиграф',
            ],

            'Петрова Анна' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Петрова Анна',
                Petrovich\Ruleset::CASE_GENITIVE => 'Петровы Анны',
                Petrovich\Ruleset::CASE_DATIVE => 'Петрове Анне',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Петрову Анну',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Петровой Анной',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Петрове Анне',
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
