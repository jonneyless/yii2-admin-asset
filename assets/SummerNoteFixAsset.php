<?php

namespace ijony\admin\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Summer Note Fix asset bundle.
 */
class SummerNoteFixAsset extends AssetBundle
{
    public $sourcePath = '@vendor/jonneyless/yii2-admin-asset/statics';
    public $css = [
        'css/summernote.fix.css',
    ];
    public $depends = [
        'ijony\admin\assets\SummerNoteAsset',
    ];
}
