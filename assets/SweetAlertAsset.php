<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * SweetAlert asset bundle.
 */
class SweetAlertAsset extends AssetBundle
{
    public $sourcePath = '@bower/sweetalert/dist';
    public $css = [
        'sweetalert.css'
    ];
    public $js = [
        'sweetalert.min.js'
    ];
}
