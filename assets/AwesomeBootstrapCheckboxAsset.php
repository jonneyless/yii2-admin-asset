<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Awesome Bootstrap Checkbox asset bundle.
 */
class AwesomeBootstrapCheckboxAsset extends AssetBundle
{

    public $css = [
        'css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css',
    ];

    public $depends = [
        'yii\bootstrap4\BootstrapPluginAsset',
    ];
}
