<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Json Editor 静态文件
 */
class JsonEditorAsset extends AssetBundle
{

    public $css = [
        'css/plugins/jsoneditor/jsoneditor.min.css',
    ];

    public $js = [
        'js/plugins/jsoneditor/jsoneditor.min.js',
    ];
}
