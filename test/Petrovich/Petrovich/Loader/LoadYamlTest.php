<?php
namespace StaticallTest\Petrovich\Petrovich\Loader;

use PHPUnit\Framework\TestCase;

use Staticall\Petrovich\Petrovich\Loader;
use StaticallTest\Mock\Loader\YamlClassNotExistsMock;
use StaticallTest\Mock\Loader\YamlClassExistsMethodNotExistsMock;
use StaticallTest\Mock\Loader\YamlClassExistsFileMethodExistsMock;
use StaticallTest\Mock\Loader\YamlClassExistsParseMethodExistsMock;

use Staticall\Petrovich\Petrovich\RuntimeException;

final class LoadYamlTest extends TestCase
{
    public function testNotExistingClass() : void
    {
        $filePath = realpath(__DIR__ . '/../../../files/test.yaml');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('You must install supported YAML parser');

        YamlClassNotExistsMock::loadYml($filePath);
    }

    public function testExistingClassNotExistingMethod() : void
    {
        $filePath = realpath(__DIR__ . '/../../../files/test.yaml');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Provided YAML parser does not have either "parse" or "parseFile" methods');

        YamlClassExistsMethodNotExistsMock::loadYml($filePath);
    }

    public function testExistingClassExistingFileMethod() : void
    {
        $filePath = realpath(__DIR__ . '/../../../files/test.yaml');

        $result   = YamlClassExistsFileMethodExistsMock::loadYml($filePath);
        $expected = $this->getExpectedTestYamlData();

        static::assertSame($expected, $result->getRules());
    }

    public function testExistingClassExistingParseMethod() : void
    {
        $filePath = realpath(__DIR__ . '/../../../files/test.yaml');

        $result   = YamlClassExistsParseMethodExistsMock::loadYml($filePath);
        $expected = $this->getExpectedTestYamlData();

        static::assertSame($expected, $result->getRules());
    }

    public function testIntegrationWithLibrary() : void
    {
        $filePath = realpath(__DIR__ . '/../../../files/test.yaml');

        $result   = Loader::loadYml($filePath);
        $expected = $this->getExpectedTestYamlData();

        static::assertSame($expected, $result->getRules());
    }

    private function getExpectedTestYamlData() : array
    {
        return [
            'middlename' => [
                'exceptions' => [
                    [
                        'gender' => 'androgynous',
                        'test'   => ['борух'],
                        'mods'   => ['.', '.', '.', '.', '.'],
                        'tags'   => ['first_word'],
                    ],
                ],

                'suffixes' => [
                    [
                        'gender' => 'male',
                        'test'   => ['мич', 'ьич', 'кич'],
                        'mods'   => ['а', 'у', 'а', 'ом', 'е'],
                    ],
                    [
                        'gender' => 'male',
                        'test'   => ['ич'],
                        'mods'   => ['а', 'у', 'а', 'ем', 'е'],
                    ],
                    [
                        'gender' => 'female',
                        'test'   => ['на'],
                        'mods'   => ['-ы', '-е', '-у', '-ой', '-е'],
                    ],
                ],
            ],
        ];
    }
}
