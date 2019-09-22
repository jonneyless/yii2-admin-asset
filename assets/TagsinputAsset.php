<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Bootstrap Tagsinput asset bundle.
 */
class TagsinputAsset extends AssetBundle
{
    public $sourcePath = '@vendor/jonneyless/yii2-admin-asset/statics';
    public $css = [
        'css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css',
        'css/fix/tagsinput.css',
    ];
    public $js = [
        'js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js',
    ];
    public $depends = [
        'ijony\admin\assets\TypeaheadAsset',
    ];
}
