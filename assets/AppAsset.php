<?php

namespace ijony\admin\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * Main admin application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    private static $_plugins = [];
    private $plugins = [
        'pace' => [
            'sourcePath' => '@bower/pace/',
            'js' => 'pace.min.js',
        ],
        'fontawesome' => [
            'sourcePath' => '@bower/fontawesome/',
            'css' => 'css/font-awesome.min.css',
        ],
        'metisMenu' => [
            'sourcePath' => '@vendor/onokumus/metismenu/dist/',
            'js' => 'metisMenu.min.js',
        ],
        'jasny-bootstrap' => [
            'sourcePath' => '@bower/jasny-bootstrap/dist/',
            'js' => 'js/jasny-bootstrap.min.js',
            'css' => 'css/jasny-bootstrap.min.css',
        ],
        'summernote' => [
            'sourcePath' => '@bower/summernote/dist/',
            'js' => [
                'summernote.js',
                'lang/summernote-zh-CN.js',
            ],
            'css' => 'summernote.css',
        ],
    ];


    public static function register($view, $plugins = [])
    {
        self::$_plugins = array_merge([
            'fontawesome',
            'pace',
            'metisMenu',
            'slimscroll',
        ], $plugins);

        return $view->registerAssetBundle(get_called_class());
    }

    public function init()
    {
        if ($this->sourcePath !== null) {
            $this->sourcePath = rtrim(Yii::getAlias($this->sourcePath), '/\\');
        }
        if ($this->basePath !== null) {
            $this->basePath = rtrim(Yii::getAlias($this->basePath), '/\\');
        }
        if ($this->baseUrl !== null) {
            $this->baseUrl = rtrim(Yii::getAlias($this->baseUrl), '/');
        }

        if(self::$_plugins !== null){
            foreach(self::$_plugins as $plugin){
                $basePath = $this->basePath;
                $baseUrl = $this->baseUrl;

                if(isset($this->plugins[$plugin])){
                    $plugin = $this->plugins[$plugin];

                    if(isset($plugin['sourcePath'])){
                        list($basePath, $baseUrl) = Yii::$app->getAssetManager()->publish($plugin['sourcePath'], $this->publishOptions);
                    }

                    if(isset($plugin['js'])){
                        if(is_array($plugin['js'])){
                            foreach($plugin['js'] as $js){
                                array_push($this->js, $baseUrl . "/". $js);
                            }
                        }else{
                            array_push($this->js, $baseUrl . "/". $plugin['js']);
                        }
                    }

                    if(isset($plugin['css'])){
                        if(is_array($plugin['css'])){
                            foreach($plugin['css'] as $css){
                                array_push($this->css, $baseUrl . "/". $css);
                            }
                        }else{
                            array_push($this->css, $baseUrl . "/". $plugin['css']);
                        }
                    }
                }
            }
        }

        list($staticPath, $staticUrl) = Yii::$app->getAssetManager()->publish('@vendor/jonneyless/yii2-admin-asset/statics', $this->publishOptions);

        array_push($this->js, $staticUrl . '/js/common.js');

        array_push($this->css, $staticUrl . '/css/bootstrap.fix.css');
        array_push($this->css, $staticUrl . '/css/animate.css');
        array_push($this->css, $staticUrl . '/css/style.css');
    }
}
