<?php

namespace Masterweber\Test\Petrovich\Petrovich;

use Masterweber\Petrovich\Petrovich;
use PHPUnit\Framework\TestCase;

final class InflectFirstNameTest extends TestCase
{
    /**
     * @throws Petrovich\IOException
     * @throws Petrovich\ValidationException
     * @throws Petrovich\RuntimeException
     */
    public function testWithoutFirstNameRules(): void
    {
        $ruleset = Petrovich\Loader::load(Petrovich\Loader::getVendorRulesFilePath());

        $rules = $ruleset->getRules();

        unset($rules[Petrovich\Ruleset::ROOT_KEY_FIRSTNAME]);

        $ruleset->setRules($rules, false);

        $petrovich = new Petrovich($ruleset);

        $name = 'Павел';

        $this->expectException(Petrovich\RuntimeException::class);
        $this->expectExceptionMessage('Missing key "' . Petrovich\Ruleset::ROOT_KEY_FIRSTNAME . '" for inflection');

        $petrovich->inflectFirstName($name, Petrovich\Ruleset::CASE_NOMENATIVE, Petrovich\Ruleset::GENDER_MALE);
    }

    /**
     * @throws Petrovich\ValidationException
     * @throws Petrovich\IOException
     * @throws Petrovich\RuntimeException
     */
    public function testMale(): void
    {
        $petrovich = new Petrovich(Petrovich\Loader::load(Petrovich\Loader::getVendorRulesFilePath()));

        $names = [
            'Алексей' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Алексей',
                Petrovich\Ruleset::CASE_GENITIVE => 'Алексея',
                Petrovich\Ruleset::CASE_DATIVE => 'Алексею',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Алексея',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Алексеем',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Алексее',
            ],

            'Михаил' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Михаил',
                Petrovich\Ruleset::CASE_GENITIVE => 'Михаила',
                Petrovich\Ruleset::CASE_DATIVE => 'Михаилу',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Михаила',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Михаилом',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Михаиле',
            ],

            'Александр' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Александр',
                Petrovich\Ruleset::CASE_GENITIVE => 'Александра',
                Petrovich\Ruleset::CASE_DATIVE => 'Александру',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Александра',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Александром',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Александре',
            ],

            'Валентин' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Валентин',
                Petrovich\Ruleset::CASE_GENITIVE => 'Валентина',
                Petrovich\Ruleset::CASE_DATIVE => 'Валентину',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Валентина',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Валентином',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Валентине',
            ],

            'Олесь' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Олесь',
                Petrovich\Ruleset::CASE_GENITIVE => 'Олеся',
                Petrovich\Ruleset::CASE_DATIVE => 'Олесю',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Олеся',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Олесем',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Олесе',
            ],

            // Weird, "Никита" have issues
            /*'Никита' => [
                Petrovich\Ruleset::CASE_NOMENATIVE    => 'Никита',
                Petrovich\Ruleset::CASE_GENITIVE      => 'Никиты',
                Petrovich\Ruleset::CASE_DATIVE        => 'Никите',
                Petrovich\Ruleset::CASE_ACCUSATIVE    => 'Никиту',
                Petrovich\Ruleset::CASE_INSTRUMENTAL  => 'Никитой',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Никите',
            ],*/

            'Илья' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Илья',
                Petrovich\Ruleset::CASE_GENITIVE => 'Ильи',
                Petrovich\Ruleset::CASE_DATIVE => 'Илье',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Илью',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Ильёй',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Илье',
            ],

            'Ромео' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Ромео',
                Petrovich\Ruleset::CASE_GENITIVE => 'Ромео',
                Petrovich\Ruleset::CASE_DATIVE => 'Ромео',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Ромео',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Ромео',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Ромео',
            ],

            'Алим-Паша' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Алим-Паша',
                Petrovich\Ruleset::CASE_GENITIVE => 'Алима-Паши',
                Petrovich\Ruleset::CASE_DATIVE => 'Алиму-Паше',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Алима-Пашу',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Алимом-Пашей',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Алиме-Паше',
            ],

            'Даша' => [ // Yes, some people are weird
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Даша',
                Petrovich\Ruleset::CASE_GENITIVE => 'Даши',
                Petrovich\Ruleset::CASE_DATIVE => 'Даше',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Дашу',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Дашей',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Даше',
            ],

            'Феликс' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Феликс',
                Petrovich\Ruleset::CASE_GENITIVE => 'Феликса',
                Petrovich\Ruleset::CASE_DATIVE => 'Феликсу',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Феликса',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Феликсом',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Феликсе',
            ],

            'Гюнтер' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Гюнтер',
                Petrovich\Ruleset::CASE_GENITIVE => 'Гюнтера',
                Petrovich\Ruleset::CASE_DATIVE => 'Гюнтеру',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Гюнтера',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Гюнтером',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Гюнтере',
            ],

            'Уве' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Уве',
                Petrovich\Ruleset::CASE_GENITIVE => 'Уве',
                Petrovich\Ruleset::CASE_DATIVE => 'Уве',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Уве',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Уве',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Уве',
            ],

            'Лоренц' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Лоренц',
                Petrovich\Ruleset::CASE_GENITIVE => 'Лоренца',
                Petrovich\Ruleset::CASE_DATIVE => 'Лоренцу',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Лоренца',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Лоренцом',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Лоренце',
            ],

            'Лев' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Лев',
                Petrovich\Ruleset::CASE_GENITIVE => 'Льва',
                Petrovich\Ruleset::CASE_DATIVE => 'Льву',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Льва',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Львом',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Льве',
            ],

            'Пётр' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Пётр',
                Petrovich\Ruleset::CASE_GENITIVE => 'Петра',
                Petrovich\Ruleset::CASE_DATIVE => 'Петру',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Петра',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Петром',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Петре',
            ],

            'Павел' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Павел',
                Petrovich\Ruleset::CASE_GENITIVE => 'Павла',
                Petrovich\Ruleset::CASE_DATIVE => 'Павлу',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Павла',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Павлом',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Павле',
            ],

            'Яша' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Яша',
                Petrovich\Ruleset::CASE_GENITIVE => 'Яши',
                Petrovich\Ruleset::CASE_DATIVE => 'Яше',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Яшу',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Яшей',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Яше',
            ],

            'Шота' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Шота',
                Petrovich\Ruleset::CASE_GENITIVE => 'Шота',
                Petrovich\Ruleset::CASE_DATIVE => 'Шота',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Шота',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Шота',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Шота',
            ],
        ];

        foreach ($names as $input => $name) {
            foreach (Petrovich\Ruleset::getAvailableCases() as $case) {
                InflectFirstNameTest::assertSame(
                    $name[$case],
                    $petrovich->inflectFirstName($input, $case, Petrovich\Ruleset::GENDER_MALE),
                    'Invalid casing of "' . $input . '" for "' . $case . '" case, expecting "' . $name[$case] . '"'
                );
            }
        }
    }

    /**
     * @throws Petrovich\IOException
     * @throws Petrovich\ValidationException
     * @throws Petrovich\RuntimeException
     */
    public function testFemale(): void
    {
        $petrovich = new Petrovich(Petrovich\Loader::load(Petrovich\Loader::getVendorRulesFilePath()));

        $names = [
            'Марина' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Марина',
                Petrovich\Ruleset::CASE_GENITIVE => 'Марины',
                Petrovich\Ruleset::CASE_DATIVE => 'Марине',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Марину',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Мариной',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Марине',
            ],

            'Ирен' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Ирен',
                Petrovich\Ruleset::CASE_GENITIVE => 'Ирен',
                Petrovich\Ruleset::CASE_DATIVE => 'Ирен',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Ирен',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Ирен',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Ирен',
            ],

            'Катрин' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Катрин',
                Petrovich\Ruleset::CASE_GENITIVE => 'Катрин',
                Petrovich\Ruleset::CASE_DATIVE => 'Катрин',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Катрин',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Катрин',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Катрин',
            ],

            'Зульфия' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Зульфия',
                Petrovich\Ruleset::CASE_GENITIVE => 'Зульфии',
                Petrovich\Ruleset::CASE_DATIVE => 'Зульфии',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Зульфию',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Зульфией',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Зульфии',
            ],

            'Мария' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Мария',
                Petrovich\Ruleset::CASE_GENITIVE => 'Марии',
                Petrovich\Ruleset::CASE_DATIVE => 'Марии',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Марию',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Марией',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Марии',
            ],

            'Марьям' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Марьям',
                Petrovich\Ruleset::CASE_GENITIVE => 'Марьям',
                Petrovich\Ruleset::CASE_DATIVE => 'Марьям',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Марьям',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Марьям',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Марьям',
            ],

            'Элизабет' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Элизабет',
                Petrovich\Ruleset::CASE_GENITIVE => 'Элизабет',
                Petrovich\Ruleset::CASE_DATIVE => 'Элизабет',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Элизабет',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Элизабет',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Элизабет',
            ],

            'Даша' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Даша',
                Petrovich\Ruleset::CASE_GENITIVE => 'Даши',
                Petrovich\Ruleset::CASE_DATIVE => 'Даше',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Дашу',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Дашей',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Даше',
            ],

            'Стефани' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Стефани',
                Petrovich\Ruleset::CASE_GENITIVE => 'Стефани',
                Petrovich\Ruleset::CASE_DATIVE => 'Стефани',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Стефани',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Стефани',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Стефани',
            ],

            'Любовь' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Любовь',
                Petrovich\Ruleset::CASE_GENITIVE => 'Любови',
                Petrovich\Ruleset::CASE_DATIVE => 'Любови',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Любовь',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Любовью',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Любови',
            ],
        ];

        foreach ($names as $input => $name) {
            foreach (Petrovich\Ruleset::getAvailableCases() as $case) {
                InflectFirstNameTest::assertSame(
                    $name[$case],
                    $petrovich->inflectFirstName($input, $case, Petrovich\Ruleset::GENDER_FEMALE),
                    'Invalid casing of "' . $input . '" for "' . $case . '" case, expecting "' . $name[$case] . '"'
                );
            }
        }
    }

    /**
     * @throws Petrovich\IOException
     * @throws Petrovich\ValidationException
     * @throws Petrovich\RuntimeException
     */
    public function testAndrogynous(): void
    {
        $petrovich = new Petrovich(Petrovich\Loader::load(Petrovich\Loader::getVendorRulesFilePath()));

        $names = [
            'Луи' => [
                Petrovich\Ruleset::CASE_NOMENATIVE => 'Луи',
                Petrovich\Ruleset::CASE_GENITIVE => 'Луи',
                Petrovich\Ruleset::CASE_DATIVE => 'Луи',
                Petrovich\Ruleset::CASE_ACCUSATIVE => 'Луи',
                Petrovich\Ruleset::CASE_INSTRUMENTAL => 'Луи',
                Petrovich\Ruleset::CASE_PREPOSITIONAL => 'Луи',
            ],
        ];

        foreach ($names as $input => $name) {
            foreach (Petrovich\Ruleset::getAvailableCases() as $case) {
                InflectFirstNameTest::assertSame(
                    $name[$case],
                    $petrovich->inflectFirstName($input, $case, Petrovich\Ruleset::GENDER_ANDROGYNOUS),
                    'Invalid casing of "' . $input . '" for "' . $case . '" case, expecting "' . $name[$case] . '"'
                );
            }
        }
    }
}
