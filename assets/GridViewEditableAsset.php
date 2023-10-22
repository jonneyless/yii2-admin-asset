<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * @since 2.0
 *
 * Customized by Nenad Živković
 * @author Qiang Xue <qiang.xue@gmail.com>
 *
 */
class GridViewEditableAsset extends AssetBundle
{

    public $sourcePath = '@vendor/jonneyless/yii2-admin-asset/statics';

    public $js = [
        'js/plugins/girdViewEditable.js',
    ];
}
