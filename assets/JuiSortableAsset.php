<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Jquery ui sortable asset bundle.
 */
class JuiSortableAsset extends AssetBundle
{

    public $sourcePath = '@vendor/jonneyless/yii2-admin-asset/statics';

    public $css = [
        'css/plugins/jquery-ui/jquery-sortable.min.css',
    ];

    public $js = [
        'js/plugins/jquery-ui/jquery-sortable.min.js',
    ];

    public $depends = [
        'yii\jui\JuiAsset',
    ];
}
