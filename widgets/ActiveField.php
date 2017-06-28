<?php

namespace ijony\admin\widgets;

use ijony\admin\assets\JasnyBootstrapAsset;
use ijony\admin\assets\SummerNoteFixAsset;
use Yii;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * 动态表单重构类
 *
 * @package common\widgets
 */
class ActiveField extends \yii\bootstrap\ActiveField
{

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

        $preview = Utils::getImg($inputValue, 300);

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

        if(isset($options['class'])){
            $model = $options['class'];
            $ids = $model::getParentIds($valueId);
            $exclude = 0;
        }else{
            $model = $this->model;
            $model = $model::className();
            $ids = $this->model->getParentIds();
            $exclude = $this->model->id ? $this->model->id : 0;
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
                    'class' => 'form-control form-control-inline',
                    'ajax-select' => Url::to(['ajax/select', 'model' => $model, 'input' => $inputName, 'exclude' => $exclude]),
                ]);
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

        $beginInput = Html::tag(
            'div',
            Html::textInput($beginInputName, $beginValue, $options) .
            Html::tag(
                'span',
                Html::button(
                    Html::tag(
                        'span',
                        '',
                        [
                            'class' => 'glyphicon glyphicon-calendar',
                            'aria-hidden' => 'true',
                        ]
                    ),
                    [
                        'class' => 'btn btn-default',
                        'onclick' => "laydate({elem: '#".$beginInputId."', format: '$layTemplate', istime: $layIsTime, istoday: false});"
                    ]
                ),
                [
                    'class' => 'input-group-btn'
                ]
            ),
            [
                'class' => 'input-group input-group-inline'
            ]
        );

        $options['id'] = $endInputId;

        $endInput = Html::tag(
            'div',
            Html::textInput($endInputName, $endValue, $options) .
            Html::tag(
                'span',
                Html::button(
                    Html::tag(
                        'span',
                        '',
                        [
                            'class' => 'glyphicon glyphicon-calendar',
                            'aria-hidden' => 'true',
                        ]
                    ),
                    [
                        'class' => 'btn btn-default',
                        'onclick' => "laydate({elem: '#".$endInputId."', format: '$layTemplate', istime: $layIsTime, istoday: false});"
                    ]
                ),
                [
                    'class' => 'input-group-btn'
                ]
            ),
            [
                'class' => 'input-group input-group-inline'
            ]
        );

        $this->parts['{input}'] = sprintf($template, $beginInput, $endInput);

        $js = <<<JS
        
laydate({
    elem: '#$beginInputId',
    format: '$layTemplate',
    istime: $layIsTime,
    istoday: false
});

laydate({
    elem: '#$endInputId',
    format: '$layTemplate',
    istime: $layIsTime,
    istoday: false
});

JS;

        Yii::$app->getView()->registerJs($js, View::POS_READY, 'between_date_' . $beginInputId);
        Yii::$app->getView()->params['plugins'][] = 'laydate';

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
                Html::button(
                    Html::tag(
                        'span',
                        '',
                        [
                            'class' => 'glyphicon glyphicon-calendar',
                            'aria-hidden' => 'true',
                        ]
                    ),
                    [
                        'class' => 'btn btn-default',
                        'onclick' => "laydate({elem: '#".$inputId."', format: '$layTemplate', istime: false, istoday: false});"
                    ]
                ),
                [
                    'class' => 'input-group-btn'
                ]
            ),
            [
                'class' => 'input-group'
            ]
        );

        $js = <<<JS
        
laydate({
    elem: '#$inputId',
    format: '$layTemplate',
    istime: false,
    istoday: false
});

JS;

        Yii::$app->getView()->registerJs($js, View::POS_READY, 'date_' . $inputId);
        Yii::$app->getView()->params['plugins'][] = 'laydate';

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
        $inputId = Html::getInputId($this->model, $this->attribute);

        $options = array_merge($this->inputOptions, $options);
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = Html::activeTextarea($this->model, $this->attribute, $options);

        $js = <<<JS
        
$('#$inputId').summernote({
    lang: 'zh-CN',
    height: 400
});

JS;

        Yii::$app->getView()->registerJs($js, View::POS_READY, 'summernote_' . $inputId);
        SummerNoteFixAsset::register(Yii::$app->getView());

        return $this;
    }

    public function tags($options = [])
    {
        $inputId = Html::getInputId($this->model, $this->attribute);
        $inputName = Html::getInputName($this->model, $this->attribute) . '[]';

        $options = array_merge($this->inputOptions, $options);
        $this->addAriaAttributes($options);
        $this->adjustLabelFor($options);
        $this->parts['{input}'] = <<<HTML
        
        <div id="tags" class="tag-input"><span>测试<input type="hidden" name="$inputName" value="测试" /></span><input id="$inputId" type="text" placeholder="添加..." /></div>

HTML;

        $js = <<<JS
        
$('#$inputId').keyup(function(e){
    var tag = $(this).val();
    
    if(e.which == 13){
        $('#tags span.exist').removeClass('exist');
        
        if($('#tags input[value="' + tag + '"]').length > 0){
            $('#tags input[value="' + tag + '"]').parent('span').addClass('exist');
        }else{
            $(this).before($('<span>').text(tag).append($('<input>').attr('type', 'hidden').attr('name', '$inputName').val(tag)));
        }
    
        $(this).val('');
    }
    
    event.stopPropagation();
    return false;
});

$(document).on('click', '#tags span', function(){
    $(this).remove();
});

JS;

        Yii::$app->getView()->registerJs($js, View::POS_READY, 'summernote_' . $inputId);

        return $this;
    }
}