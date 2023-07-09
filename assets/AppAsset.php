<?php

namespace ijony\admin\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Main admin application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@vendor/jonneyless/yii2-admin-asset/statics';
    public $css = [
        'css/style.css',
        'css/custom.css',
        'css/fix/bootstrap.css',
    ];
    public $js = [
        'js/common.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapPluginAsset',
        'ijony\admin\assets\AnimateCssAsset',
        'ijony\admin\assets\FontAwesomeAsset',
        'ijony\admin\assets\PaceAsset',
        'ijony\admin\assets\MetisMenuAsset',
        'ijony\admin\assets\SlimScrollAsset',
        'ijony\admin\assets\ToastrAsset',
        'ijony\admin\assets\SweetAlertAsset',
    ];
}
