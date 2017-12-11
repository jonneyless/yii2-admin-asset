<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * SweetAlert asset bundle.
 */
class SweetAlertAsset extends AssetBundle
{
    public $sourcePath = '@vendor/jonneyless/yii2-admin-asset/statics';
    public $css = [
        'css/plugins/sweetalert/sweetalert.css',
    ];
    public $js = [
        'js/plugins/sweetalert/sweetalert.min.js',
    ];
}
