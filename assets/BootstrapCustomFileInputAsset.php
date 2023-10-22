<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Jasny Bootstrap asset bundle.
 */
class BootstrapCustomFileInputAsset extends AssetBundle
{

    public $sourcePath = '@vendor/jonneyless/yii2-admin-asset/statics';

    public $js = [
        'js/plugins/bs-custom-file/bs-custom-file-input.min.js',
    ];

    public $depends = [
        'yii\bootstrap4\BootstrapPluginAsset',
    ];
}
