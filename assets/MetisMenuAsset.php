<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Metis Menu asset bundle.
 */
class MetisMenuAsset extends AssetBundle
{

    public $js = [
        'js/plugins/metisMenu/jquery.metisMenu.js',
    ];

    public $depends = [
        'admin\assets\AppAsset',
    ];
}
