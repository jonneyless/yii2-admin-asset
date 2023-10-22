<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Switchery asset bundle.
 */
class SwitcheryAsset extends AssetBundle
{

    public $sourcePath = '@vendor/jonneyless/yii2-admin-asset/statics';

    public $css = [
        'css/plugins/switchery/switchery.css',
    ];

    public $js = [
        'js/plugins/switchery/switchery.js',
    ];
}
