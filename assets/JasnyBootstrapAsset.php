<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Jasny Bootstrap asset bundle.
 */
class JasnyBootstrapAsset extends AssetBundle
{
    public $sourcePath = '@bower/jasny-bootstrap/dist/';
    public $css = [
        'css/jasny-bootstrap.min.css'
    ];
    public $js = [
        'js/jasny-bootstrap.min.js'
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
