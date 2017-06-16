<?php
namespace ijony\admin\widgets;

use Yii;
use yii\helpers\Html;

class ActionColumn extends \yii\grid\ActionColumn
{
    public $header = '操作';
    public $headerOptions = ['class' => 'text-right'];
    public $contentOptions = ['class' => 'text-right'];

    public function init()
    {
        parent::init();
        $this->template = Html::tag('div', $this->template, ['class' => 'btn-group']);
        $this->initDefaultButtons();
    }

    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', '查看');
        $this->initDefaultButton('update', '编辑');
        $this->initDefaultButton('remove', '移除', [
            'data-confirm' => '确定要移到回收站吗？',
            'data-method' => 'post',
        ]);
        $this->initDefaultButton('restore', '还原', [
            'data-confirm' => '确定要从回收站还原吗？',
            'data-method' => 'post',
        ]);
        $this->initDefaultButton('delete', '删除', [
            'data-confirm' => '确定要删除吗？删除后将无法恢复！',
            'data-method' => 'post',
        ]);
    }

    protected function initDefaultButton($name, $label, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $label, $additionalOptions) {
                $options = array_merge([
                    'class' => "btn btn-xs btn-default",
                    'title' => $label,
                    'aria-label' => $label,
                    'data-pjax' => '0',
                ], $additionalOptions, $this->buttonOptions);
                return Html::a($label, $url, $options);
            };
        }
    }
}
