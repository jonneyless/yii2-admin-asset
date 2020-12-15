<?php

namespace ijony\admin\widgets;

use ijony\admin\assets\ChosenAsset;
use ijony\admin\assets\DatepickerAsset;
use ijony\admin\assets\AwesomeBootstrapCheckboxAsset;
use ijony\admin\assets\DatetimepickerAsset;
use ijony\admin\assets\JasnyBootstrapAsset;
use ijony\admin\assets\MediumEditorAsset;
use ijony\admin\assets\SummerNoteAsset;
use ijony\admin\assets\SwitcheryAsset;
use ijony\admin\assets\TagsinputAsset;
use ijony\helpers\Image;
use Yii;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
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

        $groupOptions = [];
        if (isset($buttonOptions['group'])) {
            $groupOptions = $buttonOptions['group'];
            unset($buttonOptions['group']);
            foreach ($groupOptions as &$item) {
                $item = array_merge($buttonOptions, $item);
            }
        }

        $buttons = [];
        if (is_array($buttonText)) {
            foreach ($buttonText as $index => $text) {
                $buttons[] = Html::button(
                    $text,
                    isset($groupOptions[$index]) ? $groupOptions[$index] : $buttonOptions
                );
            }
        } else {
            $buttons[] = Html::button(
                $buttonText,
                $buttonOptions
            );
        }

        $options = array_merge($this->inputOptions, $options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::tag(
            'div',
            Html::activeTextInput($this->model, $this->attribute, $options) .
            Html::tag(
                'div',
                join("\n", $buttons),
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
     * 文件上传
     *
     * @param array $options
     *
     * @return $this
     */
    public function file($options = [])
    {
        $inputName = Html::getInputName($this->model, $this->attribute);

        if (isset($options['name'])) {
            $inputName = $options['name'];
            unset($options['name']);
        }

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
     * @param array $options
     *
     * @return $this
     */
    public function image($options = [])
    {
        $inputId = Html::getInputId($this->model, $this->attribute);

        $minWidth = 0;
        $minHeight = 0;
        $scale = 0;

        if (isset($options['name'])) {
            $inputName = $options['name'];
            unset($options['name']);
        } else {
            $inputName = Html::getInputName($this->model, $this->attribute);
        }

        if (isset($options['value'])) {
            $inputValue = $options['value'];
            unset($options['value']);
        } else {
            $inputValue = Html::getAttributeValue($this->model, $this->attribute);
        }

        $responsive = false;
        if (isset($options['responsive'])) {
            $responsive = $options['responsive'];
            unset($options['responsive']);
        }

        $preview = Image::getImg($inputValue, 300);

        $imageOptions = [
            'data-default' => $preview,
        ];

        if (isset($options['imageOptions'])) {
            $imageOptions = array_merge($imageOptions, $options['imageOptions']);
            unset($options['imageOptions']);
        }

        $data = Html::img($preview, $imageOptions);

        if(isset($options['width'])){
            $minWidth = $options['width'];
            unset($options['width']);
        }

        if(isset($options['height'])){
            $minHeight = $options['height'];
            unset($options['height']);
        }

        if (!isset($options['id'])) {
            $options['id'] = $inputId;
        }

        if($minWidth && $minHeight){
            $scale = $minWidth / $minHeight;
        }

        $data .= Html::hiddenInput($inputName, $inputValue, $options);
        $data .= Html::fileInput($inputName, $inputValue, ['id' => $inputId, 'class' => 'image-upload-input', 'data-width' => $minWidth, 'data-height' => $minHeight, 'data-scale' => $scale]);

        if ($responsive) {
            $this->parts['{input}'] = Html::tag('div', $data, ['class' => 'image-upload image-upload-responsive']);
        } else {
            $this->parts['{input}'] = Html::tag('div', $data, ['class' => 'image-upload']);
        }


        $js = <<<JS

$(document).on('change', '.image-upload-input', function(){
    var fileInput = $(this);
    var newFileInput = $(this).clone().val("").removeAttr('data-src');
    var label = fileInput.closest('.form-group').find('label').text();
    var minWidth = parseInt(fileInput.attr('data-width'));
    var minHeight = parseInt(fileInput.attr('data-height'));
    var oScale = parseFloat(fileInput.attr('data-scale'));
    var imgUrl = null;
    var objUrl = this.files[0];
    var filename = fileInput.val();
    var previewImg = fileInput.parent().find('img');
    
    fileExt = filename.substr(filename.lastIndexOf(".")).toLowerCase();
    
    fileInput.closest('.form-group').addClass('has-error');
    
    previewImg.attr('src', previewImg.attr('data-default'));
    
    if(fileExt != '.jpg' && fileExt != '.jpeg' && fileExt != '.png' && fileExt != '.gif'){
        toastr('error', '图片格式不对，只能上传 jpg、png 和 gif 格式！');
        fileInput.after(newFileInput).remove();
        return;
    }
    
    if(window.createObjectURL != undefined){
        imgUrl = window.createObjectURL(objUrl) ;
    }else if (window.URL != undefined){
        imgUrl = window.URL.createObjectURL(objUrl) ;
    }else if (window.webkitURL != undefined){
        imgUrl = window.webkitURL.createObjectURL(objUrl) ;
    }
    
    if(imgUrl){
        var img = new Image;
        
        img.onload = function(){
            var width = img.width;
            var height = img.height;
            var scale = width/height;
            var filesize = img;
            
            if(minWidth > 0 && minHeight == 0 && minWidth != width){
                toastr.error(label + '宽度要求为' + minWidth + 'px！');
                fileInput.after(newFileInput).remove();
                return;
            }
            
            if(minHeight > 0 && minWidth == 0 && minHeight != height){
                toastr.error(label + '高度要求为' + minWidth + 'px！');
                fileInput.after(newFileInput).remove();
                return;
            }
            
            if(minWidth > 0 && minHeight > 0 && minWidth != width && minHeight != height && (oScale + 0.01 < scale || oScale - 0.01 > scale)){
                toastr.error(label + '尺寸为 ' + minWidth + '*' + minHeight + ' px 或同比例的其他尺寸！');
                fileInput.after(newFileInput).remove();
                return;
            }
            
            fileInput.attr('data-src', imgUrl);
            previewImg.attr('src', imgUrl);
        };
        
        img.onerror=function(){  
            toastr.error(label + '上传失败！');
            fileInput.after(newFileInput).remove();
            return;
        };
        
        img.src = imgUrl;
    }
    
    fileInput.closest('.form-group').removeClass('has-error');
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
        $model = $this->model;
        $model = $model::className();
        $inputName = Html::getInputName($this->model, $this->attribute);
        $valueId = Html::getAttributeValue($this->model, $this->attribute);

        if(isset($options['class'])){
            $model = $options['class'];
            $modelData = $model::findOne($valueId);
            $ids = [0];
            if($modelData){
                $ids = $modelData->getParentIds();
            }
            $exclude = 0;
        }else{
            $primaryKey = $model::primaryKey();
            $primaryKey = current($primaryKey);
            $ids = $this->model->getParentIds();
            $exclude = $this->model->$primaryKey ? $this->model->$primaryKey : 0;
        }

        $selects = [];

        foreach($ids as $index => $parentId){
            $id = 0;
            if(isset($ids[$index + 1])){
                $id = $ids[$index + 1];
            }else{
                $id = $valueId;
            }

            $datas = $model::getSelectData($parentId, $exclude);
            if($datas){
                $params = [
                    'class' => 'form-control form-control-inline',
                    'ajax-select' => Url::to(['ajax/select', 'model' => $model, 'input' => $inputName, 'exclude' => $exclude]),
                ];

                if(!$parentId){
                    $params['prompt'] = '请选择';
                }

                $selects[] = Html::dropDownList($inputName, $id, $datas, $params);
            }
        }

        if(!$selects){
            $selects[] = Html::dropDownList($inputName, '', [], [
                'class' => 'form-control form-control-inline',
                'prompt' => '请选择',
            ]);
        }

        $this->parts['{input}'] = join("", $selects);

        $js = <<<JS
        
$(document).off('change', 'select[ajax-select]');
$(document).on('change', 'select[ajax-select]', function(){
    var select = $(this);
    var url = $(this).attr('ajax-select');
    var parent_id = $(this).val();
    
    select.nextAll('select').remove();
    
    if(parent_id == $(this).children('option').eq(0).val()){
        return false;
    }
    
    $.post(url, {parent_id: parent_id}, function(datas){
        if(datas.html){
            select.after(datas.html);
        }
    }, 'json');
});

JS;

        Yii::$app->view->registerJs($js, View::POS_READY, 'ajax-select');

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
            unset($options['has_time']);
        }

        if($hasTime){
            $dateTemplate = "Y-m-d H:i:ss";
        }else{
            $dateTemplate = "Y-m-d";
        }

        $startDate = date('Y-m-d', 0);
        if (isset($options['startDate'])) {
            $startDate = $options['startDate'];
            unset($options['startDate']);
        }

        $endDate = date('Y-m-d', 2133999048);
        if (isset($options['endDate'])) {
            $endDate = $options['endDate'];
            unset($options['endDate']);
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

        if ($hasTime) {
            $template = '<div class="datetimepicker-box"><div class="input-daterange input-group">%s<span class="input-group-addon">到</span>%s</div></div>';
        } else {
            $template = '<div class="datepicker-box"><div class="input-daterange input-group">%s<span class="input-group-addon">到</span>%s</div></div>';
        }

        if(!isset($options['class'])){
            $options['class'] = 'form-control';
        }

        $options['id'] = $beginInputId;

        $beginInput = Html::textInput($beginInputName, $beginValue, $options);

        $options['id'] = $endInputId;

        $endInput = Html::textInput($endInputName, $endValue, $options);

        $this->parts['{input}'] = sprintf($template, $beginInput, $endInput);

        $language = Yii::$app->language;

        if ($hasTime) {
            $js = <<<JS

$('.datetimepicker-box .input-daterange input').datetimepicker({
    format: 'yyyy-mm-dd hh:ii:ss',
    autoclose: true,
    todayHighlight: true,
    toggleActive: true,
    forceParse: true,
    zIndexOffset: 1001,
    startDate: '$startDate',
    endDate: '$endDate',
    language: '$language'
});

JS;

            Yii::$app->getView()->registerJs($js, View::POS_READY, 'datetimepicker-daterange');
            DatetimepickerAsset::register(Yii::$app->getView());
        } else {
            $js = <<<JS
        
$('.datepicker-box .input-daterange').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true,
    toggleActive: true,
    zIndexOffset: 1001,
    startDate: '$startDate',
    endDate: '$endDate',
    language: '$language'
});

JS;

            Yii::$app->getView()->registerJs($js, View::POS_READY, 'datepicker-daterange');
            DatepickerAsset::register(Yii::$app->getView());
        }

        return $this;
    }

    /**
     * 带时间日期选择
     *
     * @param array $options
     *
     * @return $this
     */
    public function datetime($options = [])
    {
        $dateTemplate = "Y-m-d H:i:s";
        $pickerTemplate = "yyyy-mm-dd hh:ii:ss";

        if(isset($options['dateTemplate'])){
            $dateTemplate = $options['dateTemplate'];
            unset($options['dateTemplate']);
        }

        if(isset($options['pickerTemplate'])){
            $pickerTemplate = $options['pickerTemplate'];
            unset($options['pickerTemplate']);
        }

        $startDate = date('Y-m-d', 0);
        if (isset($options['startDate'])) {
            $startDate = $options['startDate'];
            unset($options['startDate']);
        }

        $endDate = date('Y-m-d', 2133999048);
        if (isset($options['endDate'])) {
            $endDate = $options['endDate'];
            unset($options['endDate']);
        }

        $inputId = Html::getInputId($this->model, $this->attribute);
        $inputName = Html::getInputName($this->model, $this->attribute);
        $inputValue = Html::getAttributeValue($this->model, $this->attribute);

        if(!$inputValue){
            $inputValue = '';
        }else{
            $inputValue = is_integer($inputValue) ? date($dateTemplate, $inputValue) : $inputValue;
        }

        $inputValue = substr($inputValue, 0, strlen($pickerTemplate));

        if(!isset($options['class'])){
            $options['class'] = 'form-control';
        }

        $options['id'] = $inputId;

        $this->parts['{input}'] = Html::tag(
            'div',
            Html::textInput($inputName, $inputValue, $options) .
            Html::tag('span',
                Html::a(
                    Html::tag(
                        'i',
                        '',
                        [
                            'class' => 'fa fa-calendar',
                            'aria-hidden' => 'true',
                        ]
                    ),
                    'javascript:;',
                    [
                        'class' => 'btn btn-default',
                        'rel' => 'datetimepicker',
                    ]
                ),
                [
                    'class' => 'input-group-btn',
                ]
            ),
            [
                'class' => 'input-group datetime'
            ]
        );

        $language = Yii::$app->language;

        $js = <<<JS
        
$('#$inputId').datetimepicker({
    format: '$pickerTemplate',
    autoclose: true,
    todayHighlight: true,
    toggleActive: true,
    forceParse: true,
    zIndexOffset: 1001,
    startDate: '$startDate',
    endDate: '$endDate',
    language: '$language'
});

JS;

        Yii::$app->getView()->registerJs($js, View::POS_READY, 'datetimepicker-' . $inputId);
        DatetimepickerAsset::register(Yii::$app->getView());

        return $this;
    }

    /**
     * 日期选择
     *
     * @param array $options
     *
     * @return $this
     */
    public function date($options = [])
    {
        $dateTemplate = "Y-m-d";
        $pickerTemplate = "yyyy-mm-dd";

        if(isset($options['dateTemplate'])){
            $dateTemplate = $options['dateTemplate'];
            unset($options['dateTemplate']);
        }

        if(isset($options['pickerTemplate'])){
            $pickerTemplate = $options['pickerTemplate'];
            unset($options['pickerTemplate']);
        }

        $startDateTemplate = 'Y-m-d';
        $minViewMode = 0;
        if (isset($options['minViewMode'])) {
            $minViewMode = $options['minViewMode'];
            unset($options['minViewMode']);

            if ($minViewMode == 1) {
                $startDateTemplate = 'Y-m';
            }
        }

        $startDate = date($startDateTemplate, 0);
        if (isset($options['startDate'])) {
            $startDate = $options['startDate'];
            unset($options['startDate']);
        }

        $endDate = date($startDateTemplate, 2133999048);
        if (isset($options['endDate'])) {
            $endDate = $options['endDate'];
            unset($options['endDate']);
        }

        $inputId = Html::getInputId($this->model, $this->attribute);
        $inputName = Html::getInputName($this->model, $this->attribute);
        $inputValue = Html::getAttributeValue($this->model, $this->attribute);

        if(!$inputValue){
            $inputValue = '';
        }else{
            $inputValue = is_integer($inputValue) ? date($dateTemplate, $inputValue) : $inputValue;
        }

        $inputValue = substr($inputValue, 0, strlen($pickerTemplate));

        if(!isset($options['class'])){
            $options['class'] = 'form-control';
        }

        $options['id'] = $inputId;

        $this->parts['{input}'] = Html::tag(
            'div',
            Html::textInput($inputName, $inputValue, $options) .
            Html::a(
                Html::tag(
                    'i',
                    '',
                    [
                        'class' => 'fa fa-calendar',
                        'aria-hidden' => 'true',
                    ]
                ),
                'javascript:;',
                [
                    'class' => 'input-group-addon',
                    'rel' => 'datepicker',
                ]
            ),
            [
                'class' => 'input-group date'
            ]
        );

        $language = Yii::$app->language;

        $js = <<<JS
        
$('#$inputId').datepicker({
    format: '$pickerTemplate',
    autoclose: true,
    todayHighlight: true,
    toggleActive: true,
    forceParse: true,
    language: '$language',
    zIndexOffset: 1001,
    startDate: '$startDate',
    endDate: '$endDate',
    minViewMode: $minViewMode
});

JS;

        Yii::$app->getView()->registerJs($js, View::POS_READY, 'datepicker-' . $inputId);
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

        $language = Yii::$app->language;

        $js = <<<JS
        
$('.is-editor').summernote({
    lang: '$language',
    height: $height,
    toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['insert', ['link', 'picture', 'video', 'emoji']],
        ['misc', ['fullscreen', 'codeview']],
    ]
});

JS;

        Yii::$app->getView()->registerJs($js, View::POS_READY, 'summernote');
        SummerNoteAsset::register(Yii::$app->getView());

        return $this;
    }

    /**
     * 简单版编辑器
     *
     * @param array $options
     *
     * @return $this
     */
    public function tinyEditor($options = [])
    {
        if (!isset($options['class'])) {
            $options['class'] = 'form-control is-tiny-editor';
        } else {
            $options['class'] .= ' form-control is-tiny-editor';
        }

        $hiddenOptions = [];

        if (isset($options['name'])) {
            $hiddenOptions['name'] = $options['name'];
            unset($options['name']);
        }

        if (isset($options['value'])) {
            $value = $options['value'];
            $hiddenOptions['value'] = $value;
            unset($options['value']);
        } else {
            $value = Html::getAttributeValue($this->model, $this->attribute);
        }

        if (!isset($options['data-placeholder'])) {
            $options['data-placeholder'] = "请输入...";
        }

        $editorOptions = [
            'toolbar' => [
                'allowMultiParagraphSelection' => true,
                'buttons' => ['bold', 'italic', 'underline', 'anchor', 'h2', 'h3'],
                'diffLeft' => 0,
                'diffTop' => -10,
                'firstButtonClass' => 'medium-editor-button-first',
                'lastButtonClass' => 'medium-editor-button-last',
                'relativeContainer' => null,
                'standardizeSelectionStart' => false,
                'static' => false,
                'align' => 'center',
                'sticky' => false,
                'updateOnEmptySelection' => false,
            ],
            'paste' => [
                'forcePlainText' => true,
            ],
        ];

        if (isset($options['editor-opitons'])) {
            $editorOptions = ArrayHelper::merge($editorOptions, $options['editor-opitons']);
            unset($options['editor-opitons']);
        }

        $editorOptions = Json::encode($editorOptions);

        $options = array_merge($this->inputOptions, $options);
        $options['contenteditable'] = true;
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::tag('div', $value, $options) . Html::activeHiddenInput($this->model, $this->attribute, $hiddenOptions);

        $js = <<<JS
        
var editor = new MediumEditor('.is-tiny-editor', $editorOptions);

$('.is-tiny-editor').closest('form').submit(function(){
    $('.is-tiny-editor').each(function(index, obj){
        $('.is-tiny-editor').eq(index).next('input').val($('.is-tiny-editor').eq(index).html());
    });
    
    return true;
});

JS;

        Yii::$app->getView()->registerJs($js, View::POS_READY, 'medium-editor');
        MediumEditorAsset::register(Yii::$app->getView());

        return $this;
    }

    /**
     * 选择框
     *
     * @param array $options
     *
     * @return $this
     */
    public function chosen($items, $options = [])
    {
        $inputId = Html::getInputId($this->model, $this->attribute);

        $class = "form-control chosen-select";

        if(isset($options['class'])){
            $class .= $options['class'];
        }

        $options['class'] = $class;
        $options['prompt'] = '请选择';
        $options['data-placeholder'] = '请选择';

        $options = array_merge($this->inputOptions, $options);
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeDropDownList($this->model, $this->attribute, $items, $options);

        $js = <<<JS
        
$('#$inputId').chosen({
    width: "100%",
    no_results_text: "没有匹配项："
});

JS;

        Yii::$app->getView()->registerJs($js, View::POS_READY, 'chosen_' . $inputId);
        ChosenAsset::register(Yii::$app->getView());

        return $this;
    }

    /**
     * 标签输入框
     *
     * @param array $source
     * @param array $options
     *
     * @return $this
     */
    public function tags(array $source = [], $options = [])
    {
        $inputId = Html::getInputId($this->model, $this->attribute);
        $inputName = Html::getInputName($this->model, $this->attribute);

        $options = array_merge($this->inputOptions, $options);
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);

        if($source){
            $ids = Html::getAttributeValue($this->model, $this->attribute);

            if (!$ids) {
                $ids = [];
            }

            if (is_string($ids)) {
                $ids = explode(",", $ids);
            }

            $tags = [];
            foreach ($source as $item) {
                if (in_array($item['id'], $ids) && !isset($tags[$item['id']])) {
                    $tags[$item['id']] = $item['show'];
                }
            }

            $items[] = Html::hiddenInput($inputName, '');
            foreach ($tags as $id => $name) {
                $items[] = <<<HTML
                <label id="tag-$id" class="tag label label-primary">
                    $name
                    <input id="$inputId-$id" type="hidden" name="{$inputName}[]" value="$id" />
                    <span data-role="remove"></span>
                </label>
HTML;
            }
            $items[] = Html::textInput('', '', ['id' => $inputId . '-tigger']);

            $this->parts['{input}'] = Html::tag('div', join("\n", $items), [
                'class' => 'form-control bootstrap-tagsinput',
            ]);

            $source = json_encode($source, JSON_UNESCAPED_UNICODE);

            $js = <<<JS
$('#{$inputId}-tigger').closest('.bootstrap-tagsinput').click(function(){
    $('#$inputId').focus();
});
        
$('#{$inputId}-tigger').typeahead({
    source: $source,
    updater: function(item){
        $('#$inputId-tigger').closest('div').find('#tag-' + item.id).remove();
        $('#$inputId-tigger').before($('<label id="tag-' + item.id + '" class="tag label label-primary">')
            .text(item.show)
            .append($('<input id="{$inputId}-' + item.id + '" type="hidden" name="{$inputName}[]">').val(item.id))
            .append($('<span data-role="remove">'))
        );
        return '';
    }
});

$(document).on('click', '.bootstrap-tagsinput .tag', function(){
    $(this).remove();
});
JS;

        }else{
            $this->parts['{input}'] = Html::activeTextInput($this->model, $this->attribute, $options);

            $js = <<<JS

$('#$inputId').tagsinput({
    tagClass: 'tags label label-primary'
});

JS;
        }

        Yii::$app->getView()->registerJs($js, View::POS_READY, 'tags_' . $inputId);
        TagsinputAsset::register(Yii::$app->getView());

        return $this;
    }

    /**
     * @param       $enableValue
     * @param array $options
     *
     * @return $this
     */
    public function switchery($enableValue = 1, $options = [])
    {
        $disabled = false;
        $color = '#1AB394';
        $class = 'is-switchery';

        if (isset($options['color'])) {
            $color = $options['color'];
            unset($options['color']);

            $class = Html::getInputId($this->model, $this->attribute);
        }

        if (isset($options['disabled']) && $options['disabled']) {
            $class = 'is-disabled-switchery';
            $disabled = true;
        }

        if (!isset($options['class'])) {
            $options['class'] = $class;
        } else {
            $options['class'] .= ' ' . $class;
        }

        $options['label'] = false;

        if (!$enableValue) {
            $enableValue = 1;
        }

        if (is_array($enableValue)) {
            $options['uncheck'] = $enableValue[0];
            $enableValue = $enableValue[1];
        }

        $options['value'] = $enableValue;

        if ($this->form->layout !== 'horizontal') {
            $this->template = "{label}\n<div>{input}</div>\n{hint}\n{error}";
        }

        $js = <<<JS
        
var elems = Array.prototype.slice.call(document.querySelectorAll('.$class'));
elems.forEach(function(html) {
    var switchery = new Switchery(html, {
        color: '$color'
    });
    $('#' + html.id).data('switchery-object', switchery);
});

JS;

        if ($disabled) {
            $js = <<<JS
            
var elems = Array.prototype.slice.call(document.querySelectorAll('.$class'));
elems.forEach(function(html) {
    var switchery = new Switchery(html, {
        color: '$color'
    });
    switchery.disable();
    $('#' + html.id).data('switchery-object', switchery);
});

JS;
        }

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