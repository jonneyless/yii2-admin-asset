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
        'css/plugins/switchery/switchery.min.css',
    ];
    public $js = [
        'js/plugins/switchery/fastclick.js',
        'js/plugins/switchery/transitionize.min.js',
        'js/plugins/switchery/switchery.min.js',
    ];
}
