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
     * Returns all availabe genders
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
}
