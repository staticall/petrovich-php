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

    public function inflectFullName(string $fullName, int $case, string $gender = null) : string
    {
        $parsed = static::parseFullName($fullName);

        if ($gender === null) {
            $gender = static::detectGender($parsed['middleName']);
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

    public function inflectFirstName(string $firstName, int $case, string $gender = null) : string
    {
        return $this->ruleset->inflectFirstName($firstName, $case, $gender);
    }

    public function inflectMiddleName(string $middleName, int $case, string $gender = null) : string
    {
        return $this->ruleset->inflectMiddleName($middleName, $case, $gender ?? static::detectGender($middleName));
    }

    public function inflectLastName(string $lastName, int $case, string $gender = null) : string
    {
        return $this->ruleset->inflectLastName($lastName, $case, $gender);
    }

    public static function parseFullName(string $fullName) : array
    {
        $nameParts = \explode(' ', $fullName);

        $lastName   = \array_shift($nameParts);
        $middleName = \array_pop($nameParts);
        $firstName  = \implode(' ', $nameParts);

        return [
            'lastName'   => $lastName,
            'firstName'  => $firstName,
            'middleName' => $middleName,
        ];
    }

    /**
     * Определяет пол по отчеству
     *
     * @param string $middlename
     *
     * @return string
     *
     * @throws Exception
     */
    public static function detectGender(string $middlename)
    {
        if (empty($middlename)) {
            throw new Exception('Middlename cannot be empty');
        }

        switch (\mb_substr(\mb_strtolower($middlename), -4)) {
            case 'оглы':
                return Ruleset::GENDER_MALE;
            case 'кызы':
                return Ruleset::GENDER_FEMALE;
        }

        switch (\mb_substr(\mb_strtolower($middlename), -2)) {
            case 'ич':
                return Ruleset::GENDER_MALE;
            case 'на':
                return Ruleset::GENDER_FEMALE;
            default:
                return Ruleset::GENDER_ANDROGYNOUS;
        }
    }
}
