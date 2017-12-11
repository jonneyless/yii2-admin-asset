<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Select asset bundle.
 */
class SelectAsset extends AssetBundle
{
    public $sourcePath = '@vendor/jonneyless/yii2-admin-asset/statics';
    public $css = [
        'css/plugins/bootstrap-select/bootstrap-select.min.css',
        'css/fix/select.css',
    ];
    public $js = [
        'js/plugins/bootstrap-select/bootstrap-select.min.js',
        'js/plugins/bootstrap-select/bootstrap-select.zh_CN.min.js',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
