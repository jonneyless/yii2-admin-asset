<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Pace asset bundle.
 */
class PaceAsset extends AssetBundle
{
    public $sourcePath = '@bower/pace/';
    public $js = [
        'pace.min.js'
    ];
}
