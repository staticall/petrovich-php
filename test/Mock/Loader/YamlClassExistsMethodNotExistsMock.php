<?php
namespace StaticallTest\Mock\Loader;

use Staticall\Petrovich\Petrovich\Loader;

final class YamlClassExistsMethodNotExistsMock extends Loader
{
    public static function getYamlLoaderClassName() : string
    {
        return YamlLoaderWithoutMethod::class;
    }
}
