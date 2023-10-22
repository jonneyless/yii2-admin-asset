<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Font Awesome asset bundle.
 */
class FontAwesomeAsset extends AssetBundle
{

    public $sourcePath = '@vendor/jonneyless/yii2-admin-asset/statics';

    public $css = [
        'css/plugins/font-awesome/font-awesome.min.css',
    ];
}
