<?php
namespace Staticall\Petrovich;

use Staticall\Petrovich\Petrovich\Ruleset;

class Petrovich
{
    /**
     * @var Ruleset
     */
    private $ruleset;

    const CASE_NOMENATIVE    = -1; //именительный
    const CASE_GENITIVE      = 0; //родительный
    const CASE_DATIVE        = 1; //дательный
    const CASE_ACCUSATIVE    = 2; //винительный
    const CASE_INSTRUMENTAL  = 3; //творительный
    const CASE_PREPOSITIONAL = 4; //предложный
    const DEFAULT_CASE       = self::CASE_NOMENATIVE;

    const GENDER_ANDROGYNOUS = 0; // Пол не определен
    const GENDER_MALE        = 1; // Мужской
    const GENDER_FEMALE      = 2; // Женский
    const DEFAULT_GENDER     = self::GENDER_ANDROGYNOUS;

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

    public function inflectFullName(string $fullName, string $gender = null) : string
    {
        $parsed = static::parseFullName($fullName);

        if ($gender === null) {
            $gender = static::detectGender($parsed['middleName']);
        }

        return \implode(
            ' ',

            [
                $this->inflectLastName($parsed['lastName'], $gender),
                $this->inflectFirstName($parsed['firstName'], $gender),
                $this->inflectMiddleName($parsed['middleName'], $gender),
            ]
        );
    }

    public function inflectFirstName(string $firstName, string $gender = null) : string
    {
        return $this->ruleset->inflectFirstName($firstName, $gender);
    }

    public function inflectMiddleName(string $middleName, string $gender = null) : string
    {
        return $this->ruleset->inflectMiddleName($middleName, $gender ?? static::detectGender($middleName));
    }

    public function inflectLastName(string $lastName, string $gender = null) : string
    {
        return $this->ruleset->inflectLastName($lastName, $gender);
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
     * @return int
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
                return static::GENDER_MALE;
            case 'кызы':
                return static::GENDER_FEMALE;
        }

        switch (\mb_substr(\mb_strtolower($middlename), -2)) {
            case 'ич':
                return static::GENDER_MALE;
            case 'на':
                return static::GENDER_FEMALE;
            default:
                return static::GENDER_ANDROGYNOUS;
        }
    }

    /**
     * Задаём имя и слоняем его
     *
     * @param string $firstname
     * @param int    $case
     *
     * @return string
     *
     * @throws Exception
     */
    public function firstname($firstname, $case = self::DEFAULT_CASE)
    {
        if (empty($firstname)) {
            throw new Exception('Firstname cannot be empty.');
        }

        if ($case === self::CASE_NOMENATIVE) {
            return $firstname;
        }

        return $this->inflect($firstname, $case, __FUNCTION__);
    }

    /**
     * Задём отчество и склоняем его
     *
     * @param string $middlename
     * @param int    $case
     *
     * @return string
     *
     * @throws Exception
     */
    public function middlename($middlename, $case = self::DEFAULT_CASE)
    {
        if (empty($middlename)) {
            throw new Exception('Middlename cannot be empty.');
        }

        if ($case === self::CASE_NOMENATIVE) {
            return $middlename;
        }

        return $this->inflect($middlename, $case, __FUNCTION__);
    }

    /**
     * Задаём фамилию и слоняем её
     *
     * @param string $lastname
     * @param int    $case
     *
     * @return string
     *
     * @throws Exception
     */
    public function lastname($lastname, $case = self::DEFAULT_CASE)
    {
        if (empty($lastname)) {
            throw new Exception('Lastname cannot be empty.');
        }

        if ($case === self::CASE_NOMENATIVE) {
            return $lastname;
        }

        return $this->inflect($lastname, $case, __FUNCTION__);
    }

    /**
     * Функция проверяет заданное имя,фамилию или отчество на исключение и склоняет
     *
     * @param string $name
     * @param int    $case
     * @param string $type
     *
     * @return string
     */
    private function inflect($name, $case, $type)
    {
        $names  = \explode('-', $name);
        $result = [];

        foreach ($names as $namePart) {
            if (($exception = $this->checkException($namePart, $case, $type)) !== false) {
                $result[] = $exception;
            } else {
                $result[] = $this->findInRules($namePart, $case, $type);
            }
        }

        return \implode('-', $result);
    }

    /**
     * Поиск в массиве правил
     *
     * @param string $name
     * @param int    $case
     * @param string $type
     *
     * @return string
     */
    private function findInRules($name, $case, $type)
    {
        foreach ($this->rules[$type]->suffixes as $rule) {
            if (!$this->checkGender($rule->gender)) {
                continue;
            }

            foreach ($rule->test as $last_char) {
                $last_name_char = \mb_substr($name, \mb_strlen($name) - \mb_strlen($last_char), \mb_strlen($last_char));

                if ($last_char == $last_name_char) {
                    if ($rule->mods[$case] === '.') {
                        return $name;
                    }

                    return $this->applyRule($rule->mods, $name, $case);
                }
            }
        }

        return $name;
    }

    /**
     * Проверка на совпадение в исключениях
     *
     * @param string $name
     * @param int    $case
     * @param string $type
     *
     * @return bool|string
     */
    private function checkException($name, $case, $type)
    {
        if (!isset($this->rules[$type]->exceptions)) {
            return false;
        }

        $lower_name = \mb_strtolower($name);

        foreach ($this->rules[$type]->exceptions as $rule) {
            if (!$this->checkGender($rule->gender)) {
                continue;
            }

            if (\array_search($lower_name, $rule->test) === false) {
                continue;
            }

            if ($rule->mods[$case] === '.') {
                return $name;
            }

            return $this->applyRule($rule->mods, $name, $case);
        }

        return false;
    }

    /**
     * Склоняем заданное слово
     *
     * @param array  $mods
     * @param string $name
     * @param int    $case
     *
     * @return string
     */
    private function applyRule(array $mods, $name, $case)
    {
        $result  = \mb_substr($name, 0, \mb_strlen($name) - \mb_substr_count($mods[$case], '-'));
        $result .= \str_replace('-', '', $mods[$case]);

        return $result;
    }

    /**
     * Преобразует строковое обозначение пола в числовое
     *
     * @param string|int
     *
     * @return int
     */
    private function getGender($gender)
    {
        switch ($gender) {
            case 'male':
                return self::GENDER_MALE;
            case 'female':
                return self::GENDER_FEMALE;
            case 'androgynous':
                return self::GENDER_ANDROGYNOUS;
            default:
                return self::DEFAULT_GENDER;
        }
    }

    /**
     * Проверяет переданный пол на соответствие установленному
     *
     * @param string
     *
     * @return bool
     */
    private function checkGender($gender)
    {
        return $this->gender === $this->getGender($gender) || $this->getGender($gender) === self::DEFAULT_GENDER;
    }
}
