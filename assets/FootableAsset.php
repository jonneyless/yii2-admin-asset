<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Footable asset bundle.
 */
class FootableAsset extends AssetBundle
{

    public $sourcePath = '@vendor/jonneyless/yii2-admin-asset/statics';

    public $css = [
        'css/plugins/footable/footable.core.css',
    ];

    public $js = [
        'js/plugins/footable/footable.all.min.js',
    ];
}
