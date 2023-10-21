<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Bootstrap Typeahead asset bundle.
 */
class TypeaheadAsset extends AssetBundle
{

    public $js = [
        'js/plugins/typehead/bootstrap3-typeahead.min.js',
    ];

    public $depends = [
        'yii\bootstrap4\BootstrapPluginAsset',
    ];
}
