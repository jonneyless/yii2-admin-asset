<?php

namespace ijony\admin\assets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\AssetBundle;

/**
 * Bootstrap Tagsinput asset bundle.
 */
class TagsinputAsset extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap-tagsinput/dist/';
    public $css = [
        'bootstrap-tagsinput.css'
    ];
    public $js = [
        'bootstrap-tagsinput.min.js',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
