<?php

namespace ijony\admin\widgets;

use ijony\admin\assets\DatepickerAsset;
use ijony\admin\assets\AwesomeBootstrapCheckboxAsset;
use ijony\admin\assets\JasnyBootstrapAsset;
use ijony\admin\assets\SelectAsset;
use ijony\admin\assets\SelectFixAsset;
use ijony\admin\assets\SummerNoteAsset;
use ijony\admin\assets\SummerNoteFixAsset;
use ijony\admin\assets\SwitcheryAsset;
use ijony\admin\assets\TagsinputAsset;
use ijony\admin\assets\TagsinputFixAsset;
use ijony\helpers\Image;
use Yii;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * 动态表单重构类
 *
 * @inheritdoc
 * @package common\widgets
 */
class ActiveField extends \yii\bootstrap\ActiveField
{

    /**
     * @inheritdoc
     */
    public $inline = true;

    /**
     * @inheritdoc
     */
    public $checkboxTemplate = "<div class=\"checkbox\">\n{input}\n{beginLabel}\n{labelTitle}\n{endLabel}\n{error}\n{hint}\n</div>";
    /**
     * @inheritdoc
     */
    public $radioTemplate = "<div class=\"radio\">\n{input}\n{beginLabel}\n{labelTitle}\n{endLabel}\n{error}\n{hint}\n</div>";
    /**
     * @inheritdoc
     */
    public $horizontalCheckboxTemplate = "{beginWrapper}\n<div class=\"checkbox\">\n{input}\n{beginLabel}\n{labelTitle}\n{endLabel}\n</div>\n{error}\n{endWrapper}\n{hint}";
    /**
     * @inheritdoc
     */
    public $horizontalRadioTemplate = "{beginWrapper}\n<div class=\"radio\">\n{input}\n{beginLabel}\n{labelTitle}\n{endLabel}\n</div>\n{error}\n{endWrapper}\n{hint}";

    /**
     * @inheritdoc
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        AwesomeBootstrapCheckboxAsset::register(Yii::$app->getView());
    }

    /**
     * 带单位文本框
     *
     * @param       $unit
     * @param array $options
     *
     * @return $this
     */
    public function textUnitInput($unit, $options = [])
    {
        if(!$unit){
            return $this->textInput($options);
        }

        $options = array_merge($this->inputOptions, $options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::tag(
            'div',
            Html::activeTextInput($this->model, $this->attribute, $options) .
            Html::tag(
                'div',
                $unit,
                [
                    'class' => 'input-group-addon'
                ]
            ),
            [
                'class' => 'input-group'
            ]
        );

        return $this;
    }

    /**
     * 带按钮文本框
     *
     * @param       $buttonText
     * @param array $options
     *
     * @return $this
     */
    public function textButtonInput($buttonText, $options = [])
    {
        if(!$buttonText){
            return $this->textInput($options);
        }

        $buttonOptions = ['class' => 'btn btn-default'];

        if(isset($options['buttonOptions'])){
            $buttonOptions = array_merge($buttonOptions, $options['buttonOptions']);
            unset($options['buttonOptions']);
        }

        $options = array_merge($this->inputOptions, $options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::tag(
            'div',
            Html::activeTextInput($this->model, $this->attribute, $options) .
            Html::tag(
                'div',
                Html::button(
                    $buttonText,
                    $buttonOptions
                ),
                [
                    'class' => 'input-group-btn'
                ]
            ),
            [
                'class' => 'input-group'
            ]
        );

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function dropDownList($items, $options = [])
    {
        if(!isset($options['class'])){
            $options['class'] = 'form-control selectpicker';
        }else{
            $options['class'] .= ' form-control selectpicker';
        }

        $options = array_merge($this->inputOptions, $options);
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeDropDownList($this->model, $this->attribute, $items, $options);

        SelectAsset::register(Yii::$app->getView());

        return $this;
    }

    /**
     * 文件上传
     *
     * @return $this
     */
    public function file()
    {
        $inputName = Html::getInputName($this->model, $this->attribute);

        $this->parts['{input}'] = <<<HTML
<div class="fileinput fileinput-new input-group" data-provides="fileinput">
    <div class="form-control" data-trigger="fileinput">
        <i class="glyphicon glyphicon-file fileinput-exists"></i>
        <span class="fileinput-filename"></span>
    </div>
    <span class="input-group-addon btn btn-default btn-file">
        <span class="fileinput-new">选择文件</span>
        <span class="fileinput-exists">更换</span>
        <input type="file" name="$inputName"/>
    </span>
    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">移除</a>
</div>
HTML;

        JasnyBootstrapAsset::register(Yii::$app->getView());

        return $this;
    }

    /**
     * 单图上传
     *
     * @return $this
     */
    public function image()
    {
        $inputId = Html::getInputId($this->model, $this->attribute);
        $inputName = Html::getInputName($this->model, $this->attribute);
        $inputValue = Html::getAttributeValue($this->model, $this->attribute);

        $preview = Image::getImg($inputValue, 300);

        $data = Html::img($preview, ['data-default' => $preview]);

        if($inputValue){
            $data .= Html::hiddenInput($inputName, $inputValue, ['id' => $inputId]);
            $data .= Html::fileInput($inputName, $inputValue, ['class' => 'image-upload-input']);
        }else{
            $data .= Html::fileInput($inputName, $inputValue, ['id' => $inputId, 'class' => 'image-upload-input']);
        }

        $this->parts['{input}'] = Html::tag('div', $data, ['class' => 'image-upload']);

        $js = <<<JS
$('.image-upload-input').change(function(){
    var imgUrl = null;
    var objUrl = this.files[0];
    var filename = $(this).val();
    var previewImg = $(this).parent().find('img');
    
    fileExt = filename.substr(filename.lastIndexOf(".")).toLowerCase();
    
    $(this).closest('.form-group').removeClass('has-error');
    $(this).closest('.form-group').find('.help-block-error').text('');
    previewImg.attr('src', previewImg.attr('data-default'));
    
    if(fileExt != '.jpg' && fileExt != '.png' && fileExt != '.gif'){
        $(this).closest('.form-group').addClass('has-error');
        $(this).closest('.form-group').find('.help-block-error').text('图片格式不对，只能上传 jpg、png 和 gif 格式！');
    }else{
        if(window.createObjectURL != undefined){
            imgUrl = window.createObjectURL(objUrl) ;
        }else if (window.URL != undefined){
            imgUrl = window.URL.createObjectURL(objUrl) ;
        }else if (window.webkitURL != undefined){
            imgUrl = window.webkitURL.createObjectURL(objUrl) ;
        }
        
        if(imgUrl){
            previewImg.attr('src', imgUrl);
        }
    }
});
JS;

        Yii::$app->view->registerJs($js, View::POS_READY, 'image-upload');

        return $this;
    }

    /**
     * 级联下拉表单
     *
     * @param array $options
     *
     * @return $this
     */
    public function select($options = [])
    {
        $inputName = Html::getInputName($this->model, $this->attribute);
        $valueId = Html::getAttributeValue($this->model, $this->attribute);
        $primaryKey = $this->model::primaryKey();
        $primaryKey = current($primaryKey);

        if(isset($options['class'])){
            $model = $options['class'];
            $ids = $model::getParentIds($valueId);
            $exclude = 0;
        }else{
            $model = $this->model;
            $model = $model::className();
            $ids = $this->model->getParentIds();
            $exclude = $this->model->$primaryKey ? $this->model->$primaryKey : 0;
        }

        $selects = [];

        foreach($ids as $index => $parentId){
            $id = 0;
            if(isset($ids[$index + 1])){
                $id = $ids[$index + 1];
            }

            $datas = $model::getSelectDatas($parentId, $exclude);
            if($datas){
                $selects[] = Html::dropDownList($inputName, $id, $datas, [
                    'class' => 'form-control form-control-inline selectpicker',
                    'ajax-select' => Url::to(['ajax/select', 'model' => $model, 'input' => $inputName, 'exclude' => $exclude]),
                ]);
            }
        }

        if(!$selects){
            $selects[] = Html::dropDownList($inputName, '', [], [
                'class' => 'form-control form-control-inline selectpicker',
                'prompt' => '请选择',
            ]);
        }

        $this->parts['{input}'] = join("", $selects);

        $js = <<<JS
        
$(document).off('change', 'select[ajax-select]');
$(document).on('change', 'select[ajax-select]', function(){
    var select = $(this).closest('.bootstrap-select');
    var url = $(this).attr('ajax-select');
    var parent_id = $(this).val();
    
    select.nextAll('.bootstrap-select').remove();
    
    if(parent_id == $(this).children('option').eq(0).val()){
        return false;
    }
    
    $.post(url, {parent_id: parent_id}, function(datas){
        if(datas.html){
            select.after(datas.html);
            $('.selectpicker').selectpicker();
        }
    }, 'json');
});

JS;

        Yii::$app->view->registerJs($js, View::POS_READY, 'ajax-select');
        SelectAsset::register(Yii::$app->getView());
        SelectFixAsset::register(Yii::$app->getView());

        return $this;
    }

    /**
     * 起止输入表单
     *
     * @param       $endAttr
     * @param array $options
     *
     * @return $this
     */
    public function between($endAttr, $options = [])
    {
        $hasTime = true;

        $beginInputId = Html::getInputId($this->model, $this->attribute);
        $endInputId = Html::getInputId($this->model, $endAttr);

        $beginInputName = Html::getInputName($this->model, $this->attribute);
        $endInputName = Html::getInputName($this->model, $endAttr);

        $beginValue = Html::getAttributeValue($this->model, $this->attribute);
        $endValue = Html::getAttributeValue($this->model, $endAttr);

        $template = '%s &nbsp; 到 &nbsp; %s';

        if($this->form->layout == 'default'){
            $template = '<div>%s &nbsp; 到 &nbsp; %s</div>';
        }

        if(isset($options['template'])){
            $template = $options['template'];
            unset($options['template']);
        }

        if(!isset($options['class'])){
            $options['class'] = 'form-control form-control-inline';
        }

        $options['id'] = $beginInputId;

        $beginInput = Html::textInput($beginInputName, $beginValue, $options);

        $options['id'] = $endInputId;

        $endInput = Html::textInput($endInputName, $endValue, $options);

        $this->parts['{input}'] = sprintf($template, $beginInput, $endInput);

        return $this;
    }

    /**
     * 起止时间表单
     *
     * @param       $endAttr
     * @param array $options
     *
     * @return $this
     */
    public function betweenDate($endAttr, $options = [])
    {
        $hasTime = true;

        if(isset($options['has_time'])){
            $hasTime = $options['has_time'];
        }

        if($hasTime){
            $dateTemplate = "Y-m-d H:i:ss";
            $layTemplate = "YYYY-MM-DD hh:mm:ss";
            $layIsTime = 'true';
        }else{
            $dateTemplate = "Y-m-d";
            $layTemplate = "YYYY-MM-DD";
            $layIsTime = 'false';
        }

        $beginInputId = Html::getInputId($this->model, $this->attribute);
        $endInputId = Html::getInputId($this->model, $endAttr);

        $beginInputName = Html::getInputName($this->model, $this->attribute);
        $endInputName = Html::getInputName($this->model, $endAttr);

        $beginValue = Html::getAttributeValue($this->model, $this->attribute);
        $endValue = Html::getAttributeValue($this->model, $endAttr);

        if(!$beginValue){
            $beginValue = '';
        }else{
            $beginValue = is_integer($beginValue) ? date($dateTemplate, $beginValue) : $beginValue;
        }

        if(!$endValue){
            $endValue = '';
        }else{
            $endValue = is_integer($endValue) ? date($dateTemplate, $endValue) : $endValue;
        }

        $template = '<div class="input-daterange input-group">%s<span class="input-group-addon">到</span>%s</div>';

        if(!isset($options['class'])){
            $options['class'] = 'form-control';
        }

        $options['id'] = $beginInputId;

        $beginInput = Html::textInput($beginInputName, $beginValue, $options);

        $options['id'] = $endInputId;

        $endInput = Html::textInput($endInputName, $endValue, $options);

        $this->parts['{input}'] = sprintf($template, $beginInput, $endInput);

        $js = <<<JS
        
$('.input-daterange').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true,
    toggleActive: true,
    language: 'zh-CN'
});

JS;

        Yii::$app->getView()->registerJs($js, View::POS_READY, 'datepicker-daterange');
        DatepickerAsset::register(Yii::$app->getView());

        return $this;
    }

    /**
     * 日期选择
     *
     * @return $this
     */
    public function date()
    {
        $dateTemplate = "Y-m-d";
        $layTemplate = "YYYY-MM-DD";

        $inputId = Html::getInputId($this->model, $this->attribute);
        $inputName = Html::getInputName($this->model, $this->attribute);
        $inputValue = Html::getAttributeValue($this->model, $this->attribute);

        if(!$inputValue){
            $inputValue = '';
        }else{
            $inputValue = is_integer($inputValue) ? date($dateTemplate, $inputValue) : $inputValue;
        }

        if(!isset($options['class'])){
            $options['class'] = 'form-control';
        }

        $options['id'] = $inputId;

        $this->parts['{input}'] = Html::tag(
            'div',
            Html::textInput($inputName, $inputValue, $options) .
            Html::tag(
                'span',
                Html::tag(
                    'i',
                    '',
                    [
                        'class' => 'fa fa-calendar',
                        'aria-hidden' => 'true',
                    ]
                ),
                [
                    'class' => 'input-group-addon'
                ]
            ),
            [
                'class' => 'input-group date'
            ]
        );

        $js = <<<JS
        
$('.input-group.date').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true,
    toggleActive: true,
    language: 'zh-CN'
});

JS;

        Yii::$app->getView()->registerJs($js, View::POS_READY, 'datepicker');
        DatepickerAsset::register(Yii::$app->getView());

        return $this;
    }

    /**
     * 编辑器
     *
     * @param array $options
     *
     * @return $this
     */
    public function editor($options = [])
    {
        if(!isset($options['class'])){
            $options['class'] = 'is-editor';
        }else{
            $options['class'] .= ' is-editor';
        }

        $height = 400;

        if(isset($options['height'])){
            $height = $options['height'];
            unset($options['height']);
        }

        $options = array_merge($this->inputOptions, $options);
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeTextarea($this->model, $this->attribute, $options);

        $js = <<<JS
        
$('.is-editor').summernote({
    lang: 'zh-CN',
    height: $height
});

JS;

        Yii::$app->getView()->registerJs($js, View::POS_READY, 'summernote');
        SummerNoteAsset::register(Yii::$app->getView());
        SummerNoteFixAsset::register(Yii::$app->getView());

        return $this;
    }

    public function tags($options = [])
    {
        $inputId = Html::getInputId($this->model, $this->attribute);

        $options = array_merge($this->inputOptions, $options);
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeTextInput($this->model, $this->attribute, $options);

        $js = <<<JS

$('#$inputId').tagsinput({
    tagClass: 'label label-primary'
});

JS;

        Yii::$app->getView()->registerJs($js, View::POS_READY, 'tags_' . $inputId);
        TagsinputAsset::register(Yii::$app->getView());
        TagsinputFixAsset::register(Yii::$app->getView());

        return $this;
    }

    /**
     * @param       $enableValue
     * @param array $options
     *
     * @return $this
     */
    public function switchery($enableValue, $options = [])
    {
        $color = '#1AB394';
        $class = 'is-switchery';

        if(isset($options['color'])){
            $color = $options['color'];
            unset($options['color']);

            $class = Html::getInputId($this->model, $this->attribute);
        }

        if(!isset($options['class'])){
            $options['class'] = $class;
        }else{
            $options['class'] .= ' ' . $class;
        }

        $options['label'] = false;

        if(!$enableValue){
            $enableValue = 1;
        }

        if(is_array($enableValue)){
            $options['uncheck'] = $enableValue[0];
            $enableValue = $enableValue[1];
        }

        $options['value'] = $enableValue;

        if($this->form->layout !== 'horizontal'){
            $this->template = "{label}\n{input}\n{hint}\n{error}";
        }

        $js = <<<JS
        
var elem = document.querySelector('.$class');
var switchery = new Switchery(elem, {
    color: '$color'
});

JS;

        Yii::$app->getView()->registerJs($js, View::POS_READY, 'switchery_' . $class);
        SwitcheryAsset::register(Yii::$app->getView());

        $options = array_merge($this->inputOptions, $options);
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeCheckbox($this->model, $this->attribute, $options);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function checkboxList($items, $options = [])
    {
        $inline = $this->inline;
        $inputId = Html::getInputId($this->model, $this->attribute);

        if ($this->inline) {
            if (!isset($options['class'])) {
                $options['class'] = 'checkbox-group';
            }
        }

        if (!isset($options['item'])) {
            $itemOptions = isset($options['itemOptions']) ? $options['itemOptions'] : [];
            $options['item'] = function ($index, $label, $name, $checked, $value) use ($itemOptions, $inputId, $inline) {
                $inputId = $inputId . '-' . $index;
                $options = array_merge(['value' => $value, 'id' => $inputId], $itemOptions);

                if($checked){
                    $options['checked'] = $checked;
                }

                $wapperClass[] = 'checkbox';
                if(isset($itemOptions['wapperClass'])){
                    $wapperClass[] = $itemOptions['wapperClass'];
                    unset($itemOptions['wapperClass']);
                }

                if($inline){
                    $wapperClass[] = 'checkbox-inline';
                }

                return '<div class="' . join(" ", $wapperClass) . '">' . Html::input('checkbox', $name, $value, $options) . Html::label($label, $inputId) . '</div>';
            };
        }

        parent::checkboxList($items, $options);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function radioList($items, $options = [])
    {
        $inline = $this->inline;
        $inputId = Html::getInputId($this->model, $this->attribute);

        if ($this->inline) {
            if (!isset($options['class'])) {
                $options['class'] = 'radio-group';
            }
        }

        if (!isset($options['item'])) {
            $itemOptions = isset($options['itemOptions']) ? $options['itemOptions'] : [];
            $options['item'] = function ($index, $label, $name, $checked, $value) use ($itemOptions, $inputId, $inline) {
                $inputId = $inputId . '-' . $index;
                $options = array_merge(['value' => $value, 'id' => $inputId], $itemOptions);

                if($checked){
                    $options['checked'] = $checked;
                }

                $wapperClass[] = 'radio';
                if(isset($itemOptions['wapperClass'])){
                    $wapperClass[] = $itemOptions['wapperClass'];
                    unset($itemOptions['wapperClass']);
                }

                if($inline){
                    $wapperClass[] = 'radio-inline';
                }

                return '<div class="' . join(" ", $wapperClass) . '">' . Html::input('radio', $name, $value, $options) . Html::label($label, $inputId) . '</div>';
            };
        }

        parent::radioList($items, $options);
        return $this;
    }
}