<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Animate Css asset bundle.
 */
class AnimateCssAsset extends AssetBundle
{

    public $sourcePath = '@vendor/jonneyless/yii2-admin-asset/statics';

    public $css = [
        'css/plugins/animate.css',
    ];

    public $depends = [
        'yii\bootstrap4\BootstrapPluginAsset',
    ];
}
