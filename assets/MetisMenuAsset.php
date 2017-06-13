<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Metis Menu asset bundle.
 */
class MetisMenuAsset extends AssetBundle
{
    public $sourcePath = '@vendor/onokumus/metismenu/dist/';
    public $js = [
        'metisMenu.min.js'
    ];
}
