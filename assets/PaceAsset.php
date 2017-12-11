<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Pace asset bundle.
 */
class PaceAsset extends AssetBundle
{
    public $sourcePath = '@vendor/jonneyless/yii2-admin-asset/statics';
    public $js = [
        'js/pace.min.js'
    ];
}
