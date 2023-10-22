<?php

namespace ijony\admin\widgets;

use ijony\admin\enums\StatusEnum;
use yii\helpers\Html;

class Formatter extends \yii\i18n\Formatter
{

    /**
     * @param $format
     *
     * @return array|string|string[]
     */
    public function formatForPicker($format)
    {
        $format = str_replace('m', 'i', $format);
        $format = str_replace('M', 'm', $format);
        $format = str_replace('H', 'h', $format);

        return $format;
    }

    /**
     * @param $value
     * @param $copyContent
     *
     * @return string
     */
    public function asCopy($value, $copyContent = null)
    {
        $copyContent = $copyContent ?? $value;

        return $value . Html::a(Html::tag('i', '', ['class' => 'fa fa-copy']), 'javascript:;', [
                'class' => 'text-muted m-xs',
                'title' => '点击复制',
                'data-copy' => $copyContent,
                'data-toggle' => 'tooltip',
                'data-placement' => 'top',
            ]);
    }

    /**
     * @param $value
     * @param $length
     *
     * @return string
     */
    public function asSummary($value, $length = 50)
    {
        if (strlen($value) <= $length) {
            return $value;
        }

        $summary = mb_substr(strip_tags($value), 0, $length) . '... <i class="fa fa-eye"></i>';

        return Html::a($summary, 'javascript:;', [
            'data-act' => 'modal',
            'data-target' => '#modal-detail',
            'data-modal-content' => str_replace('\n', '<br>', nl2br(str_replace('"', '\"', $value))),
            'style' => 'color: #212529',
            'title' => '点击查看详情',
            'data-toggle' => 'tooltip',
            'data-placement' => 'top',
        ]);
    }

    /**
     * @param $value
     * @param $enums
     *
     * @return string|null
     */
    public function asEnum($value, $enums = [])
    {
        if ($value === null) {
            return $this->nullDisplay;
        }

        if (!$enums) {
            $enums = StatusEnum::$commonList;
        }

        if (isset($enums[$value])) {
            $text = $enums[$value];
        } elseif ($value) {
            $text = '是';
        } else {
            $text = '否';
        }

        return $text;
    }

    /**
     * 布尔值标签
     *
     * @param $value
     *
     * @return string|null
     */
    public function asBooleanLabel($value)
    {
        if ($value === null) {
            return $this->nullDisplay;
        }

        if ($value) {
            $option = ['text' => '是', 'label' => 'primary'];
        } else {
            $option = ['text' => '否', 'label' => 'danger'];
        }

        return Html::tag('span', $option['text'], [
            'class' => 'label label-' . $option['label'],
        ]);
    }

    /**
     * 标签格式化
     *
     * @param $value
     * @param $enums
     *
     * @return string|null
     */
    public function asLabel($value, $enums = [])
    {
        if ($value === null) {
            return $this->nullDisplay;
        }

        if (!$enums || is_string($enums)) {
            $enums = StatusEnum::getEnumLabel($enums ? : 'common');
        }

        if (isset($enums[$value])) {
            $option = $enums[$value];
        } elseif ($value) {
            $option = ['text' => '是', 'label' => 'primary'];
        } else {
            $option = ['text' => '否', 'label' => 'danger'];
        }

        return Html::tag('span', $option['text'] ?? '未知', [
            'class' => 'label label-' . $option['label'] ?? 'default',
        ]);
    }

    /**
     * @param $value
     * @param string $separator
     * @param string $prefix
     *
     * @return string
     */
    public function asArray($value, string $separator = '|', string $prefix = '')
    {
        if (!$value) {
            return '';
        }

        if (is_string($value)) {
            $value = (array) $value;
        }

        if ($prefix) {
            foreach ($value as $index => &$item) {
                $item = str_replace('{n}', $index + 1, $prefix) . $item;
            }
        }

        return join($separator, $value);
    }

    /**
     * @param $value
     *
     * @return string
     */
    public function asJson($value)
    {
        return nl2br(json_encode($value, JSON_PRETTY_PRINT));
    }

    /**
     * @param $value
     * @param string $style
     *
     * @return string|null
     */
    public function asProgress($value, string $style = 'primary')
    {
        if ($value === null) {
            return '';
        }

        if (is_array($value)) {
            $style = $value[1];
            $value = $value[0];
        }

        $value = floatval($value);

        if ($value <= 1) {
            $value *= 100;
        }

        $value = round($value);

        $animated = $style == 'primary' ? ' progress-bar-animated' : '';
        $style = $style ? ' progress-bar-' . $style : '';

        return <<<HTML
<div class="progress">
    <div class="progress-bar progress-bar-striped{$animated}{$style}" style="width:$value%" role="progressbar" aria-valuenow="$value" aria-valuemin="0" aria-valuemax="100"></div>
</div>
HTML;
    }
}