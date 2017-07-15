<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * SlimScroll asset bundle.
 */
class SlimScrollAsset extends AssetBundle
{
    public $sourcePath = '@bower/slim-scroll';
    public $js = [
        'jquery.slimscroll.min.js'
    ];
}
