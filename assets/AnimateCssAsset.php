<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Animate Css asset bundle.
 */
class AnimateCssAsset extends AssetBundle
{

    public $css = [
        'css/plugins/animate.css',
    ];

    public $depends = [
        'yii\bootstrap4\BootstrapPluginAsset',
    ];
}
