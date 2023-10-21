<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Medium Editor asset bundle.
 */
class MediumEditorAsset extends AssetBundle
{

    public $css = [
        'css/plugins/medium-editor/medium-editor.min.css',
        'css/plugins/medium-editor/themes/bootstrap.min.css',
    ];

    public $js = [
        'js/plugins/medium-editor/medium-editor.min.js',
        'js/plugins/medium-editor/medium-button.min.js',
    ];
}
