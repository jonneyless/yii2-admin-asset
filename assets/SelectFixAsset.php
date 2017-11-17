<?php

namespace ijony\admin\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Select Fix asset bundle.
 */
class SelectFixAsset extends AssetBundle
{
    public $sourcePath = '@vendor/jonneyless/yii2-admin-asset/statics';
    public $css = [
        'css/fix/select.css',
    ];
    public $depends = [
        'ijony\admin\assets\SelectAsset',
    ];
}
