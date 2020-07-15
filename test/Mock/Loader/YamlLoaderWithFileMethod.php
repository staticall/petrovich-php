<?php
namespace StaticallTest\Mock\Loader;

final class YamlLoaderWithFileMethod
{
    public static function parseFile(string $filePath)
    {
        return \Symfony\Component\Yaml\Yaml::parse(file_get_contents($filePath));
    }
}
