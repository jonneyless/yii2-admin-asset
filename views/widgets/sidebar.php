<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

?>

<div id="sidebar">
    <div class="sidebar-header">
        <div class="dropdown profile">
            <img class="img-circle" src="<?= $avatar ?>" />
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <strong class="block font-bold"><?= $username ?></strong>
                <span class="block text-muted"><?= $rolename ?> <b class="caret"></b></span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="<?= Url::to(['admin/reset']) ?>">修改密码</a></li>
                <li class="divider"></li>
                <li><a href="<?= Url::to(['site/logout']) ?>">注销</a></li>
            </ul>
        </div>
    </div>

    <?= $sidebarNav ?>
</div>