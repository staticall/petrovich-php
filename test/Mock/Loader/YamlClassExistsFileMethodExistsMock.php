<?php
namespace StaticallTest\Mock\Loader;

use Staticall\Petrovich\Petrovich\Loader;

final class YamlClassExistsFileMethodExistsMock extends Loader
{
    public static function getYamlLoaderClassName() : string
    {
        return YamlLoaderWithFileMethod::class;
    }
}
