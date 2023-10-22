<?php

namespace ijony\admin\enums;

abstract class Enum
{
    /**
     * @var array
     */
    protected static array $enumList = [];
    /**
     * @var array
     */
    protected static array $docList = [];

    /**
     * @var ?array
     */
    protected static array $names = [];

    /**
     * @var array
     */
    protected static array $selectData = [];

    /**
     * 获取常量注释
     *
     * @param \ReflectionClassConstant $datum
     *
     * @return string
     */
    public static function getDocComment(\ReflectionClassConstant $datum): string
    {
        $comment = $datum->getDocComment();

        if ($comment) {
            return preg_replace('/\/\*\* @var [^\s]+ (.*) \*\//', '$1', $comment);
        }

        return $datum->getName();
    }

    /**
     * 获取当前所有枚举常量
     *
     * @param string|null $prefix
     *
     * @return array
     */
    public static function all(?string $prefix = null): array
    {
        $key = static::class;

        if (!isset(self::$enumList[$key])) {
            $r = new \ReflectionClass(static::class);
            $data = $r->getReflectionConstants();

            foreach ($data as $datum) {
                self::$enumList[$key][$datum->getName()] = $datum->getValue();
                self::$docList[$key][$datum->getName()] = self::getDocComment($datum);
            }
        }

        if ($prefix) {
            $prefixUpper = strtoupper($prefix);
            $return = [];
            foreach (self::$docList[$key] as $name => $doc) {
                if (substr($name, 0, strlen($prefixUpper)) !== $prefixUpper) {
                    continue;
                }

                static::$names[$prefix][$name] = $doc;
                $return[$name] = self::$enumList[$key][$name];
            }
            return $return;
        }

        return self::$enumList[$key];
    }

    /**
     * 根据前缀获取下拉表单数据
     *
     * @param string|null $prefix
     *
     * @return mixed
     */
    public static function getSelectData(?string $prefix = null)
    {
        $values = self::all($prefix);
        $names = static::$names[$prefix] ?? static::$names;

        $data = [];
        foreach ($names as $key => $name) {
            if (!isset($values[$key])) {
                continue;
            }

            $data[$values[$key]] = $name;
        }

        return $data;
    }

    /**
     * 根据内容获取值
     *
     * @param $value
     * @param string|null $prefix
     *
     * @return false|int|string
     */
    public static function getKeyByValue($value, ?string $prefix = null)
    {
        return array_search($value, self::all($prefix));
    }

    /**
     * 获取所有值
     *
     * @param string|null $prefix
     *
     * @return array
     */
    public static function getValues(?string $prefix = null): array
    {
        return array_values(static::all($prefix));
    }

    /**
     * 获取所有的分类名称
     *
     * @param string|null $prefix
     *
     * @return array
     */
    public static function getNames(?string $prefix = null): array
    {
        static::all($prefix);

        return static::$names[$prefix] ?? [];
    }

    /**
     * 根据key获取名称
     *
     * @param $key
     * @param string|null $prefix
     *
     * @return false|mixed
     */
    public static function getNameByKey($key, ?string $prefix = null)
    {
        return self::$docList[static::class][$key] ?? false;
    }

    /**
     * 根据值获取名称
     *
     * @param $value
     * @param string|null $prefix
     *
     * @return false|mixed
     */
    public static function getNameByValue($value, ?string $prefix = null)
    {
        $key = static::getKeyByValue($value, $prefix);

        return static::getNameByKey($key, $prefix);
    }
}
