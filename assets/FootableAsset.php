<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Footable asset bundle.
 */
class FootableAsset extends AssetBundle
{
    public $sourcePath = '@bower/footable/compiled/';
    public $css = [
        'footable.bootstrap.min.css',
    ];
    public $js = [
        'footable.min.js',
    ];
}
