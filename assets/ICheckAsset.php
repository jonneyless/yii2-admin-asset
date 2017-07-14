<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Jquery iCheck asset bundle.
 */
class ICheckAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-icheck/';
    public $js = [
        'icheck.min.js',
    ];
    public $depends = [
        'ijony\admin\assets\ICheckSkinAsset',
    ];
}
