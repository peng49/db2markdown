<?php
/**
 * Description of this file
 *
 * @author  peng49 <1219955253@qq.com>
 * @date    2020/8/28 16:17
 */

namespace DB2Markdown;

/**
 * Class Factory
 * @package DB2Markdown
 */
class Factory
{
    private static $map;

    /**
     *
     *
     * @param string $type
     *
     * @return string
     * @throws \Exception
     * @date    2020/8/31 13:25
     */
    public static function getGenerator($type = 'mysql')
    {
        $className = self::getClassName($type);

        $generator = (new \ReflectionClass($className))->newInstanceWithoutConstructor();

        return $generator;
    }

    protected static function getClassName($type)
    {
        if (empty(self::$map)) {
            self::init();
        }

        if (!isset(self::$map[$type])) {
            throw new \Exception("未定义的类型:{$type}");
        }

        return self::$map[$type];
    }

    protected static function init()
    {
        $dir = __DIR__.DIRECTORY_SEPARATOR.'Generator';

        $resource = opendir($dir);
        while ($filename = readdir($resource)) {
            if (is_dir($dir.DIRECTORY_SEPARATOR.$filename)) {
                continue;
            }
            $name = substr($filename, 0, -4);

            $className = '\\'.__NAMESPACE__.'\\Generator\\'.$name;

            self::$map[strtolower($name)] = $className;
        }
    }
}
