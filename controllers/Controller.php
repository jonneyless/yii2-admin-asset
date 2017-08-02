<?php

namespace ijony\admin\controllers;

use Yii;

/**
 * 控制器基类
 *
 * @property $plugins
 * @inheritdoc
 */
class Controller extends \yii\web\Controller
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->view->params['footer']['left'] = '<div class="copyright"><strong>Copyright</strong> ijony.com © 2017</div>';
        $this->view->params['footer']['right'] = '';
    }

    public function getMenus()
    {

    }

    public function getUserName()
    {
        return 'admin';
    }

    public function getRoleName()
    {
        return '管理员';
    }

    public function getAvatar()
    {

    }

    public function getWelcome()
    {
        return '欢迎使用后台系统。';
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
        return $this->renderPartial('/site/error', [
            'message' => $message,
            'url' => $url,
            'delay' => $delay,
        ]);
    }
}
