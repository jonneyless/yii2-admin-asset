<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Font Awesome asset bundle.
 */
class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@bower/fontawesome/';
    public $css = [
        'css/font-awesome.min.css'
    ];
}
