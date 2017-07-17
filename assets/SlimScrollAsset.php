<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * SlimScroll asset bundle.
 */
class SlimScrollAsset extends AssetBundle
{
    public $sourcePath = '@bower/slimscroll';
    public $js = [
        'jquery.slimscroll.min.js'
    ];
}