<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Animate Css asset bundle.
 */
class AnimateCssAsset extends AssetBundle
{
    public $sourcePath = '@bower/animate-css/';
    public $css = [
        'animate.min.css'
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
