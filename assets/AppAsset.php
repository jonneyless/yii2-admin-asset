<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * 主资源
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@vendor/jonneyless/yii2-admin-asset/statics';

    public $css = [
        'font-awesome/css/font-awesome.css',
        'css/animate.css',
        'css/style.css',
        'css/custom.css',
    ];

    public $js = [
        'js/popper.min.js',
        'js/inspinia.js',
        'js/plugins/pace/pace.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
    ];
}
