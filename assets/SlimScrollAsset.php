<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * SlimScroll asset bundle.
 */
class SlimScrollAsset extends AssetBundle
{

    public $sourcePath = '@vendor/jonneyless/yii2-admin-asset/statics';

    public $js = [
        'js/plugins/slimscroll/jquery.slimscroll.min.js',
    ];

    public $depends = [
        'admin\assets\AppAsset',
    ];
}
