<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Toastr asset bundle.
 */
class ToastrAsset extends AssetBundle
{
    public $sourcePath = '@vendor/jonneyless/yii2-admin-asset/statics';
    public $css = [
        'css/plugins/toastr.min.css'
    ];
    public $js = [
        'js/plugins/toastr.min.js'
    ];
}
