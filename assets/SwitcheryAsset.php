<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Switchery asset bundle.
 */
class SwitcheryAsset extends AssetBundle
{
    public $sourcePath = '@bower/switchery/dist';
    public $css = [
        'switchery.min.css'
    ];
    public $js = [
        'switchery.min.js'
    ];
    public $depends = [
        'ijony\admin\assets\FastclickAsset',
        'ijony\admin\assets\TransitionizeAsset',
    ];
}
