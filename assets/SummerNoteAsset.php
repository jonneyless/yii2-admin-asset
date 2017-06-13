<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Summer Note asset bundle.
 */
class SummerNoteAsset extends AssetBundle
{
    public $sourcePath = '@bower/summernote/dist/';
    public $css = [
        'summernote.css',
    ];
    public $js = [
        'summernote.js',
        'lang/summernote-zh-CN.js',
    ];
}
