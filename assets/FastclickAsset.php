<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Fastclick asset bundle.
 */
class FastclickAsset extends AssetBundle
{
    public $sourcePath = '@bower/fastclick/lib';
    public $js = [
        'fastclick.js'
    ];
}
