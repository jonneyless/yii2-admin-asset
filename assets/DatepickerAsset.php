<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Bootstrap Datepicker asset bundle.
 */
class DatepickerAsset extends AssetBundle
{

    public $sourcePath = '@vendor/jonneyless/yii2-admin-asset/statics';

    public $css = [
        'css/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css',
    ];

    public $js = [
        'js/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js',
        'js/plugins/bootstrap-datepicker/bootstrap-datepicker.zh-CN.min.js',
    ];

    public $depends = [
        'yii\bootstrap4\BootstrapPluginAsset',
    ];
}
