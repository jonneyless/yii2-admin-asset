<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Awesome Bootstrap Checkbox asset bundle.
 */
class AwesomeBootstrapCheckboxAsset extends AssetBundle
{
    public $sourcePath = '@bower/awesome-bootstrap-checkbox/';
    public $css = [
        'awesome-bootstrap-checkbox.css',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
