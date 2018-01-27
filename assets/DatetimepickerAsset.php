<?php

namespace qooapp\admin\assets;

use yii\web\AssetBundle;

/**
 * Bootstrap Datetimepicker asset bundle.
 */
class DatetimepickerAsset extends AssetBundle
{
    public $sourcePath = '@vendor/qooapp/yii2-admin-asset/statics';
    public $css = [
        'css/plugins/bootstrap-datepicker/bootstrap-datetimepicker.min.css',
    ];
    public $js = [
        'js/plugins/bootstrap-datepicker/bootstrap-datetimepicker.min.js',
        'js/plugins/bootstrap-datepicker/bootstrap-datetimepicker.zh-CN.min.js',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
