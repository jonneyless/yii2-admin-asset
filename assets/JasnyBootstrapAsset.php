<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Jasny Bootstrap asset bundle.
 */
class JasnyBootstrapAsset extends AssetBundle
{
    public $sourcePath = '@vendor/jonneyless/yii2-admin-asset/statics';
    public $css = [
        'css/plugins/jasny-bootstrap/jasny-bootstrap.min.css'
    ];
    public $js = [
        'js/plugins/jasny-bootstrap/jasny-bootstrap.min.js'
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
