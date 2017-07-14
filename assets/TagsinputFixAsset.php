<?php

namespace ijony\admin\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Tagsinput Fix asset bundle.
 */
class TagsinputFixAsset extends AssetBundle
{
    public $sourcePath = '@vendor/jonneyless/yii2-admin-asset/statics';
    public $css = [
        'css/fix/tagsinput.css',
    ];
    public $depends = [
        'ijony\admin\assets\TagsinputAsset',
    ];
}
