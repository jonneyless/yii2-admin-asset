<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Awesome Bootstrap Checkbox asset bundle.
 */
class AwesomeBootstrapCheckboxAsset extends AssetBundle
{
    public $sourcePath = '@vendor/jonneyless/yii2-admin-asset/statics';
    public $css = [
        'css/plugins/awesome-bootstrap-checkbox.css',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
