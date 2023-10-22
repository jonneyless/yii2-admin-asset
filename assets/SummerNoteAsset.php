<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Summer Note asset bundle.
 */
class SummerNoteAsset extends AssetBundle
{

    public $sourcePath = '@vendor/jonneyless/yii2-admin-asset/statics';

    public $css = [
        'css/plugins/summernote/summernote-bs4.min.css',
        'css/fix/summernote.css',
    ];

    public $js = [
        'js/plugins/summernote/summernote-bs4.min.js',
        'js/plugins/summernote/summernote-zh-CN.min.js',
    ];
}
