<?php
namespace StaticallTest\Mock\Loader;

use Staticall\Petrovich\Petrovich\Loader;

final class YamlClassExistsParseMethodExistsMock extends Loader
{
    public static function getYamlLoaderClassName() : string
    {
        return YamlLoaderWithParseMethod::class;
    }
}
