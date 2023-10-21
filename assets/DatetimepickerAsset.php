<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Bootstrap Datetimepicker asset bundle.
 */
class DatetimepickerAsset extends AssetBundle
{

    public $css = [
        'css/plugins/bootstrap-datepicker/bootstrap-datetimepicker.min.css',
    ];

    public $js = [
        'js/plugins/bootstrap-datepicker/bootstrap-datetimepicker.min.js',
        'js/plugins/bootstrap-datepicker/bootstrap-datetimepicker.zh-CN.min.js',
    ];

    public $depends = [
        'yii\bootstrap4\BootstrapPluginAsset',
    ];
}
