<?php
namespace Staticall\Petrovich\Petrovich\Ruleset;

use Staticall\Petrovich\Petrovich;

class Validator
{
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
        if ($this->validateRootKeys($rules) === false) {
            return false;
        }

        foreach ($rules as $rule) {
            if ($this->validateSecondKeys($rule) === false) {
                return false;
            }

            foreach ($rule as $item) {
                foreach ($item as $itemData) {
                    if (\is_array($itemData) === false) {
                        return false;
                    }

                    if ($this->validateValueKeys($itemData) === false) {
                        return false;
                    }
                }
            }
        }

        return true;
    }

    public function validateRootKeys(array $rules) : bool
    {
        $availableKeys = Petrovich\Ruleset::getAvailableRootKeys();

        foreach (\array_keys($rules) as $key) {
            if (\in_array($key, $availableKeys, true) === false) {
                return false;
            }
        }

        return true;
    }

    public function validateSecondKeys(array $rule) : bool
    {
        $availableKeys = Petrovich\Ruleset::getAvailableSecondKeys();

        foreach (\array_keys($rule) as $ruleSecondKey) {
            if (\in_array($ruleSecondKey, $availableKeys, true) === false) {
                return false;
            }
        }

        return true;
    }

    public function validateValueKeys(array $rule)
    {
        $availableKeys    = Petrovich\Ruleset::getAvailableValueKeys();
        $availableGenders = Petrovich\Ruleset::getAvailableGenders();

        foreach (\array_keys($rule) as $ruleValueKey) {
            if (\in_array($ruleValueKey, $availableKeys, true) === false) {
                return false;
            }
        }

        if (\array_key_exists(Petrovich\Ruleset::VALUE_KEY_TEST, $rule)) {
            if (\is_array($rule[Petrovich\Ruleset::VALUE_KEY_TEST]) === false) {
                return false;
            }
        }

        if (\array_key_exists(Petrovich\Ruleset::VALUE_KEY_MODS, $rule)) {
            if (\is_array($rule[Petrovich\Ruleset::VALUE_KEY_MODS]) === false) {
                return false;
            }
        }

        if (\array_key_exists(Petrovich\Ruleset::VALUE_KEY_TAGS, $rule)) {
            if (\is_array($rule[Petrovich\Ruleset::VALUE_KEY_TAGS]) === false) {
                return false;
            }
        }

        if (\array_key_exists(Petrovich\Ruleset::VALUE_KEY_GENDER, $rule)) {
            if (\is_string($rule[Petrovich\Ruleset::VALUE_KEY_GENDER]) === false) {
                return false;
            }

            if (\in_array($rule[Petrovich\Ruleset::VALUE_KEY_GENDER], $availableGenders) === false) {
                return false;
            }
        }

        return true;
    }
}
