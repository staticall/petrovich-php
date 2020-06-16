<?php
namespace Staticall\Petrovich\Petrovich;

use Symfony\Component\Yaml\Yaml;

class Loader
{
    const FILE_TYPE_JSON    = 'json';
    const FILE_TYPE_YML     = 'yml';
    const DEFAULT_FILE_TYPE = self::FILE_TYPE_JSON;

    /**
     * Loads provided file
     *
     * @param string      $filePath
     * @param string|null $fileType
     * @param bool        $shouldValidate
     *
     * @return Ruleset
     * @throws IOException
     * @throws RuntimeException
     * @throws ValidationException
     */
    public static function load(string $filePath, ?string $fileType = null, bool $shouldValidate = false) : Ruleset
    {
        if ($fileType === null) {
            $fileType = static::determineFileType($filePath);
        }

        switch ($fileType) {
            case static::FILE_TYPE_JSON:
                return static::loadJson($filePath, $shouldValidate);
            case static::FILE_TYPE_YML:
                return static::loadYml($filePath, $shouldValidate);
            default:
                throw new RuntimeException('File has invalid format');
        }
    }

    /**
     * Loads rules from JSON
     *
     * @param string $filePath
     * @param bool   $shouldValidate
     *
     * @return Ruleset
     *
     * @throws IOException
     * @throws ValidationException
     */
    public static function loadJson(string $filePath, bool $shouldValidate = false) : Ruleset
    {
        /** @var array $rules */
        $rules = \json_decode(static::loadFile($filePath), true);

        return new Ruleset($rules, $shouldValidate);
    }

    /**
     * Loads rules from Yaml
     *
     * @param string $filePath
     * @param bool   $shouldValidate
     *
     * @return Ruleset
     *
     * @throws ValidationException
     */
    public static function loadYml(string $filePath, bool $shouldValidate = false) : Ruleset
    {
        if (!class_exists(Yaml::class)) {
            // @codeCoverageIgnoreStart
            throw new RuntimeException('Unable to load ruleset. Install symfony/yaml package');
            // @codeCoverageIgnoreEnd
        }
        $rules = Yaml::parseFile($filePath);

        return new Ruleset($rules, $shouldValidate);
    }

    /**
     * Loads file content into a string
     *
     * @param string $filePath
     *
     * @return string
     *
     * @throws IOException
     */
    public static function loadFile(string $filePath) : string
    {
        if (\is_readable($filePath) === false) {
            throw new IOException('File "' . $filePath . '" doesn\'t exist or is not readable');
        }

        return \file_get_contents($filePath);
    }

    /**
     * Determines file type from passed file path
     *
     * @param string $filePath
     *
     * @return string
     */
    public static function determineFileType(string $filePath) : string
    {
        $extension = \pathinfo($filePath, \PATHINFO_EXTENSION);

        if ($extension === '') {
            return static::DEFAULT_FILE_TYPE;
        }

        if (\in_array($extension, static::getAvailableFileTypes(), true) === false) {
            return static::DEFAULT_FILE_TYPE;
        }

        return $extension;
    }

    /**
     * Returns available file types
     *
     * @return array
     */
    public static function getAvailableFileTypes() : array
    {
        return [
            static::FILE_TYPE_JSON,
            static::FILE_TYPE_YML,
        ];
    }

    public static function getVendorRulesFilePath(string $type = self::FILE_TYPE_JSON)
    {
        return __DIR__ . '/../../vendor/cloudloyalty/petrovich-rules/rules.' . $type;
    }
}
