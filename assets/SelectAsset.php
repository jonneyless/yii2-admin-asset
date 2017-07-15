<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Select asset bundle.
 */
class SelectAsset extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap-select/dist/';
    public $css = [
        'css/bootstrap-select.min.css',
    ];
    public $js = [
        'js/bootstrap-select.min.js',
        'js/i18n/defaults-zh_CN.js',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
