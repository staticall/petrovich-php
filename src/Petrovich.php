<?php
namespace Staticall\Petrovich;

use Staticall\Petrovich\Petrovich\Ruleset;

class Petrovich
{
    /**
     * @var Ruleset
     */
    private $ruleset;

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
    public function setRuleset(Ruleset $ruleset) : Petrovich
    {
        $this->ruleset = $ruleset;

        return $this;
    }

    /**
     * @return Ruleset
     */
    public function getRuleset() : Ruleset
    {
        return $this->ruleset;
    }

    /**
     * Inflects full name, format must be:
     * LastName FirstName MiddleName
     *
     * @param string      $fullName Full name, separated by a single space, format: LastName FirstName MiddleName
     * @param int         $case     Case constant
     * @param string|null $gender   Gender constant
     *
     * @return string
     *
     * @throws Exception
     */
    public function inflectFullName(string $fullName, int $case, string $gender = null) : string
    {
        $parsed = static::parseFullName($fullName);

        if ($gender === null) {
            $gender = Ruleset::GENDER_ANDROGYNOUS;

            if ($parsed['middleName'] !== null) {
                $gender = static::detectGender($parsed['middleName']);
            }
        }

        if ($parsed['middleName'] === null) {
            return \implode(
                ' ',

                [
                    $this->inflectLastName($parsed['lastName'], $case, $gender),
                    $this->inflectFirstName($parsed['firstName'], $case, $gender),
                ]
            );
        }

        return \implode(
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
     * @param int    $case
     * @param string $gender
     *
     * @return string
     *
     * @throws Petrovich\RuntimeException
     */
    public function inflectFirstName(string $firstName, int $case, string $gender) : string
    {
        return $this->ruleset->inflectFirstName($firstName, $case, $gender);
    }

    /**
     * Inflects middle name only
     *
     * @param string      $middleName
     * @param int         $case
     * @param string|null $gender
     *
     * @return string
     *
     * @throws Exception
     */
    public function inflectMiddleName(string $middleName, int $case, string $gender = null) : string
    {
        return $this->ruleset->inflectMiddleName($middleName, $case, $gender ?? static::detectGender($middleName));
    }

    /**
     * Inflects last name only
     *
     * @param string $lastName
     * @param int    $case
     * @param string $gender
     *
     * @return string
     *
     * @throws Petrovich\RuntimeException
     */
    public function inflectLastName(string $lastName, int $case, string $gender) : string
    {
        return $this->ruleset->inflectLastName($lastName, $case, $gender);
    }

    public static function parseFullName(string $fullName) : array
    {
        $nameParts = \explode(' ', $fullName);

        $lastName   = \array_shift($nameParts);
        $middleName = \array_pop($nameParts);
        if (\count($nameParts) > 1 && \in_array($middleName, ['оглы', 'кызы'])) {
            $middleName = \array_pop($nameParts) . ' ' . $middleName;
        }
        $firstName  = \implode(' ', $nameParts);

        if (empty($firstName)) {
            $firstName = $middleName;

            $middleName = null;
        }

        return [
            'lastName'   => $lastName,
            'firstName'  => $firstName,
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
    public static function detectGender(string $middleName)
    {
        if (empty($middleName)) {
            throw new Exception('Middle name cannot be empty');
        }

        switch (\mb_substr(\mb_strtolower($middleName), -4)) {
            case 'оглы':
                return Ruleset::GENDER_MALE;
            case 'кызы':
                return Ruleset::GENDER_FEMALE;
        }

        switch (\mb_substr(\mb_strtolower($middleName), -2)) {
            case 'ич':
                return Ruleset::GENDER_MALE;
            case 'на':
                return Ruleset::GENDER_FEMALE;
            default:
                return Ruleset::GENDER_ANDROGYNOUS;
        }
    }
}
