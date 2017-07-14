<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Jquery iCheck Skin asset bundle.
 */
class ICheckSkinAsset extends AssetBundle
{
    public $sourcePath = '@vendor/jonneyless/yii2-admin-asset/statics';
    public $css = [
        'css/icheck/custom.css',
    ];
}
