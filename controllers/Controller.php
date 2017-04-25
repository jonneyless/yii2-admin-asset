<?php

namespace ijony\admin\controllers;

use Yii;

/**
 * 控制器基类
 *
 * @property $region_id
 * @property $region_name
 * @property $authed_route
 * @property $authed_auth
 * @property $plugins
 */
class Controller extends \yii\web\Controller
{

    public $region_id = 0;
    public $region_name = '';
    public $authed_route = [];
    public $authed_auth = [];
    public $plugins = [
        'before' => [
            'fontawesome',
            'pace',
            'metisMenu',
            'slimscroll',
        ],
        'after' => [
            'common',
        ],
    ];

    public function init()
    {
        parent::init();

        $this->view->params['plugins'] = [];
        $this->view->params['route'] = '';
        $this->view->params['footer']['left'] = '<div class="copyright"><strong>Copyright</strong> ijony.com © 2017</div>';
        $this->view->params['footer']['right'] = '';
    }

    public function getPlugins()
    {
        return $this->view->params['plugins'];
    }

    /**
     * 提示跳转页
     *
     * @param        $message
     * @param string $url
     * @param int    $delay
     *
     * @return string
     */
    public function message($message, $url = 'javascript:history.go(-1)', $delay = 3)
    {
        return $this->render('/site/error', [
            'message' => $message,
            'url' => $url,
            'delay' => $delay,
        ]);
    }
}
