<?php

use yii\helpers\Url;
use common\models\Menu;

/* @var $this yii\web\View */

?>

<div id="sidebar">
    <div class="sidebar-header">
        <div class="dropdown profile">
            <img class="img-circle" src="img/default-avatar.gif" />
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <strong class="block font-bold"><?= Yii::$app->user->identity->username ?></strong>
                <span class="block text-muted"><?= Yii::$app->user->identity->getRoleName() ?> <b class="caret"></b></span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="<?= Url::to(['admin/reset']) ?>">修改密码</a></li>
                <li class="divider"></li>
                <li><a href="<?= Url::to(['site/logout']) ?>">注销</a></li>
            </ul>
        </div>
    </div>

    <ul id="sidebar-nav" class="nav sidebar-nav">
        <?php foreach($datas as $data){ ?>
            <?php if(!$data['show']) continue; ?>
            <li<?php if($data['active']){ ?> class="active"<?php } ?>>
                <a href="<?= $data['url'] ?>">
                    <i class="fa <?= $data['icon'] ?>"></i>
                    <span class="nav-label"><?= $data['name'] ?></span>
                    <?php if($data['submenu']){ ?>
                    <span class="fa arrow"></span>
                    <?php } ?>
                </a>
                <?php if($data['submenu']){ ?>
                <ul class="nav sidebar-subnav collapse">
                    <?php foreach($data['submenu'] as $menu){ ?>
                        <?php if(!$menu['show']) continue; ?>
                        <li<?php if($menu['active']){ ?> class="active"<?php } ?>>
                            <a href="<?= $menu['url'] ?>">
                                <?= $menu['name'] ?>
                                <?php if($menu['submenu']){ ?>
                                    <span class="fa arrow"></span>
                                <?php } ?>
                            </a>
                            <?php if($menu['submenu']){ ?>
                            <ul class="nav sidebar-subnav">
                                <?php foreach($menu['submenu'] as $submenu){ ?>
                                    <?php if(!$submenu['show']) continue; ?>
                                    <li<?php if($submenu['active']){ ?> class="active"<?php } ?>><a href="<?= $submenu['url'] ?>"><?= $submenu['name'] ?></a></li>
                                <?php } ?>
                            </ul>
                            <?php } ?>
                        </li>
                    <?php } ?>
                </ul>
                <?php } ?>
            </li>
        <?php } ?>
    </ul>
</div>