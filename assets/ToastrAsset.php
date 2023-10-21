<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Toastr asset bundle.
 */
class ToastrAsset extends AssetBundle
{

    public $css = [
        'css/plugins/toastr/toastr.min.css',
    ];

    public $js = [
        'js/plugins/toastr/toastr.min.js',
    ];
}
