<?php

namespace Masterweber\Test\Petrovich\Petrovich;

use Masterweber\Petrovich\Exception;
use Masterweber\Petrovich\Petrovich;
use PHPUnit\Framework\TestCase;

final class DetectGenderTest extends TestCase
{
    public function testEmptyMiddleName(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Middle name cannot be empty');

        Petrovich::detectGender('');
    }

    /**
     * @throws Exception
     */
    public function testGenderless(): void
    {
        $middleNames = [
            'test',
            'тест',
        ];

        foreach ($middleNames as $middleName) {
            DetectGenderTest::assertSame(Petrovich\Ruleset::GENDER_ANDROGYNOUS, Petrovich::detectGender($middleName));
        }
    }

    /**
     * @throws Exception
     */
    public function testFemale(): void
    {
        $middleNames = [
            'Адамовна',
            'Афанасьевна',
            'Акимовна',
            'Альбертовна',
            'Александровна',
            'Алексеевна',
            'Анатольевна',
            'Андреевна',
            'Анисимовна',
            'Антоновна',
            'Аркадьевна',
            'Арсеньевна',
            'Артемовна',
            'Артуровна',
            'Архиповна',
            'Аскольдовна',
            'Августовна',
            'Богдановна',
            'Болеславовна',
            'Борисовна',
            'Вадимовна',
            'Валентиновна',
            'Валерьевна',
            'Васильевна',
            'Вениаминовна',
            'Викентиевна',
            'Викторовна',
            'Витальевна',
            'Владимировна',
            'Владиславовна',
            'Всеволодовна',
            'Вячеславовна',
            'Гавриловна',
            'Геннадиевна',
            'Георгиевна',
            'Герасимовна',
            'Германовна',
            'Глебовна',
            'Григорьевна',
            'Даниловна',
            'Давидовна',
            'Денисовна',
            'Дмитриевна',
            'Ефимовна',
            'Ефремовна',
            'Егоровна',
            'Еремеевна',
            'Евгеньевна',
            'Ждановна',
            'Зиновьевна',
            'Игнатьевна',
            'Игоревна',
            'Ильинична',
            'Илларионовна',
            'Иннокентиевна',
            'Ипполитовна',
            'Ивановна',
            'Кирилловна',
            'Кондратьевна',
            'Константиновна',
            'Кузьминична',
            'Лаврентьевна',
            'Лазаревна',
            'Леонидовна',
            'Леоновна',
            'Леонтьевна',
            'Львовна',
            'Макаровна',
            'Максимовна',
            'Марковна',
            'Матвеевна',
            'Мироновна',
            'Михайловна',
            'Мстиславовна',
            'Натановна',
            'Наумовна',
            'Никифоровна',
            'Никитична',
            'Николаевна',
            'Ниловна',
            'Олеговна',
            'Осиповна',
            'Оскаровна',
            'Прохоровна',
            'Павловна',
            'Петровна',
            'Робертовна',
            'Романовна',
            'Ростиславовна',
            'Рубеновна',
            'Рудольфовна',
            'Руслановна',
            'Савельевна',
            'Семеновна',
            'Серафимовна',
            'Сергеевна',
            'Станиславовна',
            'Степановна',
            'Святославовна',
            'Тарасовна',
            'Тимофеевна',
            'Тимуровна',
            'Тихоновна',
            'Федоровна',
            'Федосеевна',
            'Феликсовна',
            'Филипповна',
            'Эдуардовна',
            'Эльдаровна',
            'Эммануиловна',
            'Юльевна',
            'Юрьевна',
            'Яковлевна',
            'Яновна',
            'Ярославовна',
        ];

        foreach ($middleNames as $middleName) {
            DetectGenderTest::assertSame(Petrovich\Ruleset::GENDER_FEMALE, Petrovich::detectGender($middleName));
        }
    }

    /**
     * @throws Exception
     */
    public function testMale(): void
    {
        $middleNames = [
            'Александрович',
            'Алексеевич',
            'Анатольевич',
            'Андреевич',
            'Антонович',
            'Аркадьевич',
            'Арсеньевич',
            'Артемович',
            'Афанасьевич',
            'Богданович',
            'Борисович',
            'Вадимович',
            'Валентинович',
            'Валериевич',
            'Васильевич',
            'Викторович',
            'Витальевич',
            'Владимирович',
            'Всеволодович',
            'Вячеславович',
            'Гаврилович',
            'Геннадиевич',
            'Георгиевич',
            'Глебович',
            'Григорьевич',
            'Давыдович',
            'Данилович',
            'Денисович',
            'Дмитриевич',
            'Евгеньевич',
            'Егорович',
            'Емельянович',
            'Ефимович',
            'Иванович',
            'Игоревич',
            'Ильич',
            'Иосифович',
            'Кириллович',
            'Константинович',
            'Корнеевич',
            'Леонидович',
            'Львович',
            'Макарович',
            'Максимович',
            'Маркович',
            'Матвеевич',
            'Митрофанович',
            'Михайлович',
            'Назарович',
            'Наумович',
            'Николаевич',
            'Олегович',
            'Павлович',
            'Петрович',
            'Платонович',
            'Робертович',
            'Родионович',
            'Романович',
            'Савельевич',
            'Семенович',
            'Сергеевич',
            'Станиславович',
            'Степанович',
            'Тарасович',
            'Тимофеевич',
            'Тихонович',
            'Федорович',
            'Феликсович',
            'Филиппович',
            'Эдуардович',
            'Юрьевич',
            'Яковлевич',
            'Ярославович',
        ];

        foreach ($middleNames as $middleName) {
            DetectGenderTest::assertSame(Petrovich\Ruleset::GENDER_MALE, Petrovich::detectGender($middleName));
        }
    }

    /**
     * @throws Exception
     */
    public function testMaleExceptionTurkic(): void
    {
        $middleNames = [
            'Октай',
            'Али',
            'Анна',
            'Евграфий',
            'Жожоба',
        ];

        $suffixes = [
            Petrovich::SUFFIX_TURKIC_MALE_OGLY,
            Petrovich::SUFFIX_TURKIC_MALE_ULY,
            Petrovich::SUFFIX_TURKIC_MALE_UULU,
        ];

        foreach ($middleNames as $middleName) {
            foreach ($suffixes as $suffix) {
                DetectGenderTest::assertSame(
                    Petrovich\Ruleset::GENDER_MALE,
                    Petrovich::detectGender($middleName . ' ' . $suffix)
                );
            }
        }
    }

    /**
     * @throws Exception
     */
    public function testFemaleExceptionTurkic(): void
    {
        $middleNames = [
            'Октай',
            'Али',
            'Анна',
            'Евграфий',
            'Жожоба',
        ];

        $suffixes = [
            Petrovich::SUFFIX_TURKIC_FEMALE_KYZY,
            Petrovich::SUFFIX_TURKIC_FEMALE_GYZY,
        ];

        foreach ($middleNames as $middleName) {
            foreach ($suffixes as $suffix) {
                DetectGenderTest::assertSame(
                    Petrovich\Ruleset::GENDER_FEMALE,
                    Petrovich::detectGender($middleName . ' ' . $suffix)
                );
            }
        }
    }
}
