<?php

namespace ijony\admin\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * 侧边栏组件
 *
 * @property array $items
 * @property string $defaultIcon
 *
 * User: Jony < jonneyless@163.com >
 * Date: 2016/10/9
 * Time: 9:29
 */

class Sidebar extends Widget
{

    /**
     * 菜单数据
     *
     * @var array
     * ```php
     * [
     *     [
     *         'name' => '字符串',  // 必要，菜单名称
     *         'url' => '字符串或者数组',  // 必要，菜单链接
     *         'show' => '布尔值',  // 可选，用于菜单项显示控制
     *         'active' => '布尔值',      // 可选，用于设置菜单选中状态
     *         'icon' => '字符串',      // 可选，用于设置菜单 Icon，一级菜单有效
     *         'items' => '数组', // 可选, 子菜单
     *     ]
     * ]
     * ```
     */
    public $items = [];

    public $username = '';
    public $rolename = '';
    public $avatar = '';

    /**
     * 一级菜单默认 Icon
     *
     * @var string
     */
    public $defaultIcon = 'square';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if(!$this->avatar){
            $baseUrl = Yii::$app->getAssetManager()->getPublishedUrl('@vendor/jonneyless/yii2-admin-asset/statics');
            $this->avatar = $baseUrl . '/img/default-avatar.gif';
        }

        if(!$this->username){
            $this->username = 'admin';
        }

        if(!$this->rolename){
            $this->rolename = '管理员';
        }

        if(!Yii::$app->user->getIsGuest()){
            $user = Yii::$app->user->getIdentity();

            if(isset($user->avatar)){
                $this->avatar = \ijony\helpers\Url::getStatic($user->avatar);
            }

            if(method_exists($user, 'getRoleName')){
                $this->rolename = $user->getRoleName();
            }
        }
    }

    /**
     * @inheritdoc
     * @return string
     */
    public function run()
    {
        return $this->render('/widgets/sidebar', [
            'username' => $this->username,
            'rolename' => $this->rolename,
            'avatar' => $this->avatar,
            'sidebarNav' => $this->renderItems()
        ]);
    }

    private function renderItems()
    {
        $items = [];

        $this->parseItems();

        foreach($this->items as $item){
            $icon = Html::tag('i', '', ['class' => $item['icon']]);
            $name = Html::tag('span', $item['name'], ['class' => 'nav-label']);
            $arrow = '';
            $childs = '';
            $options = [];

            if(isset($item['items']) && $item['items']){
                $arrow = Html::tag('span', '', ['class' => 'fa arrow']);
                $childs = Html::tag('ul', $this->renderChilds($item['items']), ['class' => 'nav nav-second-level collapse']);
            }

            $link = Html::a($icon . $name . $arrow, $item['url']);

            if($item['active']){
                $options = ['class' => 'active'];
            }

            $items[] = Html::tag('li', $link . $childs, $options);
        }

        return implode("\n", $items);
    }

    private function renderChilds($items)
    {
        foreach($items as &$item){
            $name = $item['name'];
            $arrow = '';
            $childs = '';
            $options = [];

            if(isset($item['items']) && $item['items']){
                $arrow = Html::tag('span', '', ['class' => 'fa arrow']);
                $childs = Html::tag('ul', $this->renderChilds($item['items']), ['class' => 'nav nav-third-level collapse']);
            }

            $link = Html::a($name . $arrow, $item['url']);

            if($item['active']){
                $options = ['class' => 'active'];
            }

            $item = Html::tag('li', $link . $childs, $options);
        }

        return implode("\n", $items);
    }

    private function parseItems()
    {
        foreach($this->items as &$item){
            if(!isset($item['name']) || !isset($item['url'])){
                continue;
            }

            if(is_array($item['url'])){
                $item['url'] = Url::to($item['url']);
            }

            if(!isset($item['active'])){
                $item['active'] = false;
            }

            if(!isset($item['show'])){
                $item['show'] = true;
            }

            if(!isset($item['icon']) || !$item['icon']){
                $item['icon'] = $this->defaultIcon;
            }

            $item['icon'] = 'fa fa-' . $item['icon'];

            if(isset($item['items'])){
                $item = $this->parseChild($item);
            }
        }
    }

    private function parseChild($data)
    {
        foreach($data['items'] as &$item){
            if(!isset($item['name']) || !isset($item['url'])){
                continue;
            }

            if(is_array($item['url'])){
                $item['url'] = Url::to($item['url']);
            }

            if(!isset($item['active'])){
                $item['active'] = false;
            }

            if(!isset($item['show'])){
                $item['show'] = true;
            }

            if(isset($item['items'])){
                $item = $this->parseChild($item);
            }

            if($item['active']){
                $data['active'] = true;
            }
        }

        return $data;
    }

    public function renderItem()
    {

    }
}