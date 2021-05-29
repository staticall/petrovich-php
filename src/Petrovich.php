<?php

namespace Masterweber\Petrovich;

use JetBrains\PhpStorm\ArrayShape;
use Masterweber\Petrovich\Petrovich\Ruleset;

use function array_pop;
use function array_shift;
use function count;
use function explode;
use function implode;
use function in_array;
use function mb_strtolower;
use function mb_substr;

class Petrovich
{
    const SUFFIX_TURKIC_MALE_OGLY = 'оглы';
    const SUFFIX_TURKIC_MALE_ULY = 'улы';
    const SUFFIX_TURKIC_MALE_UULU = 'уулу';
    const SUFFIX_TURKIC_FEMALE_KYZY = 'кызы';
    const SUFFIX_TURKIC_FEMALE_GYZY = 'гызы';

    const SUFFIX_RUSSIAN_MALE = 'ич';
    const SUFFIX_RUSSIAN_FEMALE = 'на';

    /**
     * @var Ruleset
     */
    private Ruleset $ruleset;

    /**
     * @param Ruleset $ruleset
     */
    public function __construct(Ruleset $ruleset)
    {
        $this->setRuleset($ruleset);
    }

    /**
     * @param Ruleset $ruleset
     *
     * @return Petrovich
     */
    public function setRuleset(Ruleset $ruleset): Petrovich
    {
        $this->ruleset = $ruleset;

        return $this;
    }

    /**
     * @return Ruleset
     */
    public function getRuleset(): Ruleset
    {
        return $this->ruleset;
    }

    /**
     * Inflects full name, format must be:
     * LastName FirstName MiddleName
     *
     * @param string $fullName Full name, separated by a single space, format: LastName FirstName MiddleName
     * @param int $case Case constant
     * @param string|null $gender Gender constant
     *
     * @return string
     *
     * @throws Exception
     */
    public function inflectFullName(string $fullName, int $case, string $gender = null): string
    {
        $parsed = static::parseFullName($fullName);

        if ($gender === null) {
            $gender = Ruleset::GENDER_ANDROGYNOUS;

            if ($parsed['middleName'] !== null) {
                $gender = static::detectGender($parsed['middleName']);
            }
        }

        if ($parsed['middleName'] === null) {
            return implode(
                ' ',

                [
                    $this->inflectLastName($parsed['lastName'], $case, $gender),
                    $this->inflectFirstName($parsed['firstName'], $case, $gender),
                ]
            );
        }

        return implode(
            ' ',

            [
                $this->inflectLastName($parsed['lastName'], $case, $gender),
                $this->inflectFirstName($parsed['firstName'], $case, $gender),
                $this->inflectMiddleName($parsed['middleName'], $case, $gender),
            ]
        );
    }

    /**
     * Inflects first name only
     *
     * @param string $firstName
     * @param int $case
     * @param string $gender
     *
     * @return string
     *
     * @throws Petrovich\RuntimeException
     */
    public function inflectFirstName(string $firstName, int $case, string $gender): string
    {
        return $this->ruleset->inflectFirstName($firstName, $case, $gender);
    }

    /**
     * Inflects middle name only
     *
     * @param string $middleName
     * @param int $case
     * @param string|null $gender
     *
     * @return string
     *
     * @throws Exception
     */
    public function inflectMiddleName(string $middleName, int $case, string $gender = null): string
    {
        return $this->ruleset->inflectMiddleName($middleName, $case, $gender ?? static::detectGender($middleName));
    }

    /**
     * Inflects last name only
     *
     * @param string $lastName
     * @param int $case
     * @param string $gender
     *
     * @return string
     *
     * @throws Petrovich\RuntimeException
     */
    public function inflectLastName(string $lastName, int $case, string $gender): string
    {
        return $this->ruleset->inflectLastName($lastName, $case, $gender);
    }

    #[ArrayShape(['lastName' => 'null|string', 'firstName' => 'null|string', 'middleName' => 'null|string'])]
    public static function parseFullName(
        string $fullName
    ): array {
        $nameParts = explode(' ', $fullName);

        $lastName = array_shift($nameParts);
        $middleName = array_pop($nameParts);

        if (
            count($nameParts) > 1
            &&
            in_array($middleName, static::getTurkicSuffixes(), true)
        ) {
            $middleName = array_pop($nameParts) . ' ' . $middleName;
        }

        $firstName = implode(' ', $nameParts);

        if (empty($firstName)) {
            $firstName = $middleName;

            $middleName = null;
        }

        return [
            'lastName' => $lastName,
            'firstName' => $firstName,
            'middleName' => $middleName,
        ];
    }

    /**
     * Определяет пол по отчеству
     *
     * @param string $middleName
     *
     * @return string
     *
     * @throws Exception
     */
    public static function detectGender(string $middleName): string
    {
        if (empty($middleName)) {
            throw new Exception('Middle name cannot be empty');
        }

        $middleNameLowercase = mb_strtolower($middleName);

        switch (mb_substr($middleNameLowercase, -4)) {
            case static::SUFFIX_TURKIC_MALE_OGLY:
            case static::SUFFIX_TURKIC_MALE_UULU:
                return Ruleset::GENDER_MALE;
            case static::SUFFIX_TURKIC_FEMALE_KYZY:
            case static::SUFFIX_TURKIC_FEMALE_GYZY:
                return Ruleset::GENDER_FEMALE;
        }

        switch (mb_substr($middleNameLowercase, -3)) {
            case static::SUFFIX_TURKIC_MALE_ULY:
                return Ruleset::GENDER_MALE;
        }

        switch (mb_substr($middleNameLowercase, -2)) {
            case static::SUFFIX_RUSSIAN_MALE:
                return Ruleset::GENDER_MALE;
            case static::SUFFIX_RUSSIAN_FEMALE:
                return Ruleset::GENDER_FEMALE;
        }

        return Ruleset::GENDER_ANDROGYNOUS;
    }

    /**
     * Возвращает поддерживаемые суффиксы для тюркских отчеств
     *
     * @return array
     *
     * @link https://ru.wikipedia.org/wiki/Отчество#Тюркские_отчества
     */
    public static function getTurkicSuffixes(): array
    {
        return [
            static::SUFFIX_TURKIC_MALE_OGLY,
            static::SUFFIX_TURKIC_MALE_UULU,
            static::SUFFIX_TURKIC_MALE_ULY,

            static::SUFFIX_TURKIC_FEMALE_KYZY,
            static::SUFFIX_TURKIC_FEMALE_GYZY,
        ];
    }
}
