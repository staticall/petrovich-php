<?php
namespace Staticall\Petrovich\Petrovich;

class Ruleset
{
    const ROOT_KEY_FIRSTNAME  = 'firstname';
    const ROOT_KEY_LASTNAME   = 'lastname';
    const ROOT_KEY_MIDDLENAME = 'middlename';

    const SECOND_KEY_EXCEPTIONS = 'exceptions';
    const SECOND_KEY_SUFFIXES   = 'suffixes';

    const VALUE_KEY_GENDER = 'gender';
    const VALUE_KEY_MODS   = 'mods';
    const VALUE_KEY_TEST   = 'test';
    const VALUE_KEY_TAGS   = 'tags';

    const GENDER_ANDROGYNOUS = 'androgynous';
    const GENDER_MALE        = 'male';
    const GENDER_FEMALE      = 'female';

    const MOD_INITIAL = '.';

    const CASE_NOMENATIVE    = -1; //именительный
    const CASE_GENITIVE      = 0; //родительный
    const CASE_DATIVE        = 1; //дательный
    const CASE_ACCUSATIVE    = 2; //винительный
    const CASE_INSTRUMENTAL  = 3; //творительный
    const CASE_PREPOSITIONAL = 4; //предложный
    const DEFAULT_CASE       = self::CASE_NOMENATIVE;

    /**
     * @var array List of parsed Petrovich rules
     */
    private $rules = [];

    /**
     * @param array $rules
     * @param bool  $shouldValidate
     *
     * @throws ValidationException
     */
    public function __construct(array $rules = [], bool $shouldValidate = false)
    {
        if (!empty($rules)) {
            $this->setRules($rules, $shouldValidate);
        }
    }

    /**
     * @param array $rules
     * @param bool  $shouldValidate
     *
     * @return Ruleset
     *
     * @throws ValidationException
     */
    public function setRules(array $rules, bool $shouldValidate = false) : Ruleset
    {
        if ($shouldValidate && $this->validate($rules) === false) {
            throw new ValidationException('Input didn\'t pass validation');
        }

        $this->rules = $rules;

        return $this;
    }

    /**
     * @return array
     */
    public function getRules() : array
    {
        return $this->rules;
    }

    /**
     * Performs basic validation over provided rules
     * Useful for testing and/or any format changes
     *
     * @param array $rules
     *
     * @return bool
     */
    public function validate(array $rules) : bool
    {
        $availableRootKeys   = static::getAvailableRootKeys();
        $availableSecondKeys = static::getAvailableSecondKeys();
        $availableValueKeys  = static::getAvailableValueKeys();
        $availableGenders    = static::getAvailableGenders();

        foreach (\array_keys($rules) as $key) {
            if (\in_array($key, $availableRootKeys, true) === false) {
                return false;
            }
        }

        foreach ($rules as $rule) {
            foreach (\array_keys($rule) as $ruleSecondKey) {
                if (\in_array($ruleSecondKey, $availableSecondKeys, true) === false) {
                    return false;
                }
            }

            foreach ($rule as $item) {
                foreach ($item as $itemData) {
                    if (\is_array($itemData) === false) {
                        return false;
                    }

                    foreach (\array_keys($itemData) as $ruleValueKey) {
                        if (\in_array($ruleValueKey, $availableValueKeys, true) === false) {
                            return false;
                        }
                    }

                    if (\array_key_exists(static::VALUE_KEY_TEST, $itemData)) {
                        if (\is_array($itemData[static::VALUE_KEY_TEST]) === false) {
                            return false;
                        }
                    }

                    if (\array_key_exists(static::VALUE_KEY_MODS, $itemData)) {
                        if (\is_array($itemData[static::VALUE_KEY_MODS]) === false) {
                            return false;
                        }
                    }

                    if (\array_key_exists(static::VALUE_KEY_TAGS, $itemData)) {
                        if (\is_array($itemData[static::VALUE_KEY_TAGS]) === false) {
                            return false;
                        }
                    }

                    if (\array_key_exists(static::VALUE_KEY_GENDER, $itemData)) {
                        if (\is_string($itemData[static::VALUE_KEY_GENDER]) === false) {
                            return false;
                        }

                        if (\in_array($itemData[static::VALUE_KEY_GENDER], $availableGenders) === false) {
                            return false;
                        }
                    }
                }
            }
        }

        return true;
    }

    /**
     * Returns all availabe root keys
     *
     * @return array
     */
    public static function getAvailableRootKeys() : array
    {
        return [
            static::ROOT_KEY_FIRSTNAME,
            static::ROOT_KEY_LASTNAME,
            static::ROOT_KEY_MIDDLENAME,
        ];
    }

    /**
     * Returns all availabe second keys
     *
     * @return array
     */
    public static function getAvailableSecondKeys() : array
    {
        return [
            static::SECOND_KEY_EXCEPTIONS,
            static::SECOND_KEY_SUFFIXES,
        ];
    }

    /**
     * Returns all availabe value keys
     *
     * @return array
     */
    public static function getAvailableValueKeys() : array
    {
        return [
            static::VALUE_KEY_GENDER,
            static::VALUE_KEY_MODS,
            static::VALUE_KEY_TEST,
            static::VALUE_KEY_TAGS,
        ];
    }

    /**
     * Returns all available genders
     *
     * @return array
     */
    public static function getAvailableGenders() : array
    {
        return [
            static::GENDER_ANDROGYNOUS,
            static::GENDER_MALE,
            static::GENDER_FEMALE,
        ];
    }

    /**
     * Returns all available cases
     *
     * @return array
     */
    public static function getAvailableCases() : array
    {
        return [
            static::CASE_NOMENATIVE,
            static::CASE_GENITIVE,
            static::CASE_DATIVE,
            static::CASE_ACCUSATIVE,
            static::CASE_INSTRUMENTAL,
            static::CASE_PREPOSITIONAL,
        ];
    }

    /**
     * @param string $lastName
     * @param int    $case
     * @param string $gender
     *
     * @return string
     */
    public function inflectLastName(string $lastName, int $case, string $gender) : string
    {
        return $this->inflect($lastName, $case, $gender, $this->getRules()[static::ROOT_KEY_LASTNAME]);
    }

    /**
     * @param string $firstName
     * @param int    $case
     * @param string $gender
     *
     * @return string
     */
    public function inflectFirstName(string $firstName, int $case, string $gender) : string
    {
        return $this->inflect($firstName, $case, $gender, $this->getRules()[static::ROOT_KEY_FIRSTNAME]);
    }

    /**
     * @param string $middleName
     * @param int    $case
     * @param string $gender
     *
     * @return string
     */
    public function inflectMiddleName(string $middleName, int $case, string $gender) : string
    {
        return $this->inflect($middleName, $case, $gender, $this->getRules()[static::ROOT_KEY_MIDDLENAME]);
    }

    /**
     * @param string $input
     * @param int    $case
     * @param string $gender
     * @param array  $rule
     *
     * @return string
     */
    public function inflect(string $input, int $case, string $gender, array $rule) : string
    {
        if ($case === static::CASE_NOMENATIVE) {
            // Because Petrovich does not provide a case for nomenative case, because it's useless
            return $input;
        }

        $inputParts = \explode('-', $input);
        $result     = [];

        foreach ($inputParts as $inputPart) {
            if ($this->isInExceptions($inputPart, $case, $gender, $rule) === true) {
                $result[] = $this->getException($inputPart, $case, $gender, $rule);

                continue;
            }

            $result[] = $this->findMatchingRule($inputPart, $case, $gender, $rule);
        }

        return \implode('-', $result);
    }

    /**
     * @param string $input
     * @param int    $case
     * @param string $gender
     * @param array  $rule
     *
     * @return string
     */
    protected function findMatchingRule(
        string $input,
        int $case,
        string $gender,
        array $rule
    ) : string
    {
        if (empty($rule[static::SECOND_KEY_SUFFIXES])) {
            return $input;
        }

        $inputLowercase = \mb_strtolower($input);

        foreach ($rule[static::SECOND_KEY_SUFFIXES] as $toTest) {
            if ($toTest[static::VALUE_KEY_GENDER] !== $gender) {
                continue;
            }

            foreach ($toTest[static::VALUE_KEY_TEST] as $ending) {
                $inputEnding = \mb_substr(
                    $inputLowercase,
                    \mb_strlen($input) - \mb_strlen($ending),
                    \mb_strlen($ending)
                );

                if ($ending === $inputEnding) {
                    if ($toTest[static::VALUE_KEY_MODS][$case] === static::MOD_INITIAL) {
                        return $input;
                    }

                    return $this->applyRule($toTest[static::VALUE_KEY_MODS][$case], $input);
                }
            }
        }

        return $input;
    }

    /**
     * Checks if current rule is in exceptions
     *
     * @param string $input
     * @param int    $case
     * @param string $gender
     * @param array  $rule
     *
     * @return bool
     */
    protected function isInExceptions(string $input, int $case, string $gender, array $rule) : bool
    {
        return $this->getException($input, $case, $gender, $rule) !== null;
    }

    /**
     * @param string $input
     * @param int    $case
     * @param string $gender
     * @param array  $rule
     *
     * @return string|null
     */
    protected function getException(string $input, int $case, string $gender, array $rule) : ?string
    {
        if (empty($rule[static::SECOND_KEY_EXCEPTIONS])) {
            return null;
        }

        $inputLowercase = \mb_strtolower($input);

        foreach ($rule[static::SECOND_KEY_EXCEPTIONS] as $exception) {
            if ($exception[static::VALUE_KEY_GENDER] !== $gender) {
                continue;
            }

            if (\in_array($inputLowercase, $exception[static::VALUE_KEY_TEST], true) === false) {
                continue;
            }

            if ($exception[static::VALUE_KEY_MODS][$case] === static::MOD_INITIAL) {
                return $input;
            }

            return $this->applyRule($exception[static::VALUE_KEY_MODS][$case], $input);
        }

        return null;
    }

    /**
     * @param string $mod
     * @param string $input
     *
     * @return string
     */
    protected function applyRule(string $mod, string $input) : string
    {
        $result  = \mb_substr($input, 0, \mb_strlen($input) - \mb_substr_count($mod, '-'));
        $result .= \str_replace('-', '', $mod);

        return $result;
    }
}
