<?php

namespace ijony\admin\assets;

use yii\web\AssetBundle;

/**
 * Bootstrap Tagsinput asset bundle.
 */
class TagsinputAsset extends AssetBundle
{
    public $sourcePath = [
        '@bower/bootstrap-tagsinput/dist/',
        '@vendor/jonneyless/yii2-admin-asset/statics',
    ];
    public $css = [
        ['bootstrap-tagsinput.css'],
        ['css/fix/tagsinput.css'],
    ];
    public $js = [
        ['bootstrap-tagsinput.min.js'],
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        if($this->sourcePath !== NULL){
            if(is_array($this->sourcePath)){
                $this->sourcePath = array_map([__CLASS__, 'parsePath'], $this->sourcePath);
            }else{
                $this->sourcePath = self::parsePath($this->sourcePath);
            }
        }
        if($this->basePath !== NULL){
            $this->basePath = self::parsePath($this->basePath);
        }
        if($this->baseUrl !== NULL){
            $this->baseUrl = self::parseUrl($this->baseUrl);
        }
    }

    private static function parsePath($data)
    {
        return rtrim(Yii::getAlias($data), '/\\');
    }

    private static function parseUrl($data)
    {
        return rtrim(Yii::getAlias($data), '/');
    }

    /**
     * @inheritdoc
     */
    public function publish($am)
    {
        if(is_array($this->sourcePath)){
            $sourcePaths = $this->sourcePath;
            $css = $this->css;
            $js = $this->js;

            foreach($sourcePaths as $index => $sourcePath){
                $this->sourcePath = $sourcePath;
                $this->css = $css[$index];
                $this->js = $js[$index];

                unset($this->basePath);
                unset($this->baseUrl);

                $this->doPublish($am);
            }
        }else{
            $this->doPublish($am);
        }
    }

    private function doPublish($am)
    {
        if($this->sourcePath !== NULL && !isset($this->basePath, $this->baseUrl)){
            list ($this->basePath, $this->baseUrl) = $am->publish($this->sourcePath, $this->publishOptions);
        }

        if(isset($this->basePath, $this->baseUrl) && ($converter = $am->getConverter()) !== NULL){
            foreach($this->js as $i => $js){
                if(is_array($js)){
                    $file = array_shift($js);
                    if(Url::isRelative($file)){
                        $js = ArrayHelper::merge($this->jsOptions, $js);
                        array_unshift($js, $converter->convert($file, $this->basePath));
                        $this->js[$i] = $js;
                    }
                }else if(Url::isRelative($js)){
                    $this->js[$i] = $converter->convert($js, $this->basePath);
                }
            }
            foreach($this->css as $i => $css){
                if(is_array($css)){
                    $file = array_shift($css);
                    if(Url::isRelative($file)){
                        $css = ArrayHelper::merge($this->cssOptions, $css);
                        array_unshift($css, $converter->convert($file, $this->basePath));
                        $this->css[$i] = $css;
                    }
                }else if(Url::isRelative($css)){
                    $this->css[$i] = $converter->convert($css, $this->basePath);
                }
            }
        }
    }
}
