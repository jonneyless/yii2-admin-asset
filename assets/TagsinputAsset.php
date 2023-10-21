<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Bootstrap Tagsinput asset bundle.
 */
class TagsinputAsset extends AssetBundle
{

    public $css = [
        'css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css',
        'css/fix/tagsinput.css',
    ];

    public $js = [
        'js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js',
    ];

    public $depends = [
        'admin\assets\TypeaheadAsset',
    ];
}
