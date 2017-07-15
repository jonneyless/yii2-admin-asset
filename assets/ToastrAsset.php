<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Toastr asset bundle.
 */
class ToastrAsset extends AssetBundle
{
    public $sourcePath = '@bower/toastr/';
    public $css = [
        'toastr.min.css'
    ];
    public $js = [
        'toastr.min.js'
    ];
}
