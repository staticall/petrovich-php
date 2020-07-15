<?php
namespace StaticallTest\Mock\Loader;

use Staticall\Petrovich\Petrovich\Loader;

use Staticall\Petrovich\Petrovich\Ruleset;

final class YamlClassAndMethodExistsMock extends Loader
{
    public static function loadYml(string $filePath, bool $shouldValidate = false) : Ruleset
    {
        return static::loadJson(str_replace(['.yml', '.yaml'], '.json', $filePath), $shouldValidate);
    }
}
