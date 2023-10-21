<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * 主资源
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';

    public $baseUrl = '@web';

    public $css = [
        'font-awesome/css/font-awesome.css',
        'css/animate.css',
        'css/style.css',
        'css/custom.css',
    ];

    public $js = [
        'js/jquery.timers.js',
        'js/popper.min.js',
        'js/inspinia.js',
        'js/plugins/pace/pace.min.js',
        'js/common.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
    ];
}
