<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Transitionize asset bundle.
 */
class TransitionizeAsset extends AssetBundle
{
    public $sourcePath = '@bower/transitionize/dist';
    public $js = [
        'transitionize.min.js'
    ];
}
