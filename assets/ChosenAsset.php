<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Chosen asset bundle.
 */
class ChosenAsset extends AssetBundle
{
    public $sourcePath = '@vendor/jonneyless/yii2-admin-asset/statics';
    public $css = [
        'css/plugins/chosen/chosen.min.css',
        'css/plugins/chosen/bootstrap-chosen.css',
        'css/fix/chosen.css',
    ];
    public $js = [
        'js/plugins/chosen/chosen.jquery.min.js',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
