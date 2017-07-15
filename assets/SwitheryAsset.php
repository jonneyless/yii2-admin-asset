<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Swithery asset bundle.
 */
class SwitheryAsset extends AssetBundle
{
    public $sourcePath = '@bower/swithery/dist';
    public $css = [
        'swithery.min.css'
    ];
    public $js = [
        'swithery.min.js'
    ];
    public $depends = [
        'ijony\admin\assets\FastclickAsset',
        'ijony\admin\assets\TransitionizeAsset',
    ];
}
