<?php
namespace StaticallTest\Mock\Loader;

use Staticall\Petrovich\Petrovich\Loader;

final class YamlClassNotExistsMock extends Loader
{
    public static function getYamlLoaderClassName() : string
    {
        return '\ClassNameNotExistsForSure';
    }
}
