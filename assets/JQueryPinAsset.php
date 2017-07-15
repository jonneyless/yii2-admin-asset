<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * JQuery Pin asset bundle.
 */
class JQueryPinAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery.pin/';
    public $css = [
        'css/style.css'
    ];
    public $js = [
        'jquery.pin.min.js'
    ];
}
