<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Bootstrap Datepicker asset bundle.
 */
class DatepickerAsset extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap-datepicker/dist/';
    public $css = [
        'css/bootstrap-datepicker.min.css',
    ];
    public $js = [
        'js/bootstrap-datepicker.min.js',
        'locales/bootstrap-datepicker.zh-CN.min.js',
    ];
}
