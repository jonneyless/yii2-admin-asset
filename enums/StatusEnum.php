<?php

namespace ijony\admin\enums;

class StatusEnum extends Enum
{

    /** @var int 删除 */
    const STATUS_DELETE = 0;
    /** @var int 禁用 */
    const STATUS_INACTIVE = 1;
    /** @var int 启用 */
    const STATUS_ACTIVE = 9;

    private static $enumLabelMaps = [];

    public static array $labelTypes = ['common', 'task'];

    /** @var array|string[]  */
    public static array $commonList = [
        self::STATUS_ACTIVE => '启用',
        self::STATUS_INACTIVE => '禁用',
    ];

    /** @var array|string[]  */
    public static array $commonLabel = [
        self::STATUS_ACTIVE => 'primary',
        self::STATUS_INACTIVE => 'danger',
    ];

    /**
     * @param $type
     *
     * @return array|mixed
     */
    public static function getEnumLabel($type)
    {
        if (!in_array($type, self::$labelTypes)) {
            $type = 'common';
        }

        if (!isset(self::$enumLabelMaps[$type]) || self::$enumLabelMaps[$type] === null) {
            $list = self::${$type . 'List'};
            $label = self::${$type . 'Label'};

            $maps = [];
            foreach ($list as $key => $text) {
                $maps[$key] = ['text' => $text, 'label' => $label[$key] ?? 'default'];
            }

            self::$enumLabelMaps[$type] = $maps;
        }

        return self::$enumLabelMaps[$type];
    }
}