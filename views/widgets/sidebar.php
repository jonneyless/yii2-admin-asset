<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

?>

<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span><img alt="image" class="img-circle" src="<?= $avatar ?>" /></span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs"><strong class="font-bold"><?= $username ?></strong></span>
                            <span class="text-muted text-xs block"><?= $rolename ?> <b class="caret"></b></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeIn m-t-xs">
                        <li><a href="<?= Url::to(['admin/reset']) ?>">修改密码</a></li>
                        <li class="divider"></li>
                        <li><a href="<?= Url::to(['site/logout']) ?>">注销</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>

            <?= $sidebarNav ?>
        </ul>
    </div>
</nav>