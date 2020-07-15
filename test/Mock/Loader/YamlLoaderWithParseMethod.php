<?php
namespace StaticallTest\Mock\Loader;

final class YamlLoaderWithParseMethod
{
    public static function parse(string $content)
    {
        return \Symfony\Component\Yaml\Yaml::parse($content);
    }
}
