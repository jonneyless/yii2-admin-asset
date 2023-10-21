<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Jquery Timers asset bundle.
 */
class TimersAsset extends AssetBundle
{

    public $css = [
    ];

    public $js = [
        'js/jquery.timers.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
