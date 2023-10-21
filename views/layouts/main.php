<?php

/* @var $this \yii\web\View */
/* @var $content string */

use ijony\admin\assets\AppAsset;
use ijony\admin\assets\MetisMenuAsset;
use ijony\admin\assets\SlimScrollAsset;
use ijony\admin\assets\ToastrAsset;
use ijony\admin\widgets\Sidebar;
use ijony\admin\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\helpers\Url;

AppAsset::register($this);
ToastrAsset::register($this);
MetisMenuAsset::register($this);
SlimScrollAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <div id="wrapper">
        <?= Sidebar::widget([
            'items' => $this->context->getMenus(),
        ]); ?>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-top-links navbar-right">
                        <li><span class="m-r-sm text-muted welcome-message"><?= $this->context->getWelcome() ?></span></li>
                        <?php if (isset($this->context->topButtons) && $this->context->topButtons) { ?>
                            <?php foreach ($this->context->topButtons as $button) { ?>
                                <li class="no-small">
                                    <a href="<?= $button['url'] ?>">
                                        <i class="fa fa-<?= $button['icon'] ?>" aria-hidden="true"></i> <?= $button['name'] ?>
                                    </a>
                                </li>
                            <?php } ?>
                        <?php } ?>
                        <?php if (Yii::$app->user->getIsGuest()) { ?>
                            <li>
                                <a href="<?= Url::to(['/site/login']) ?>">
                                    <i class="fa fa-sign-in" aria-hidden="true"></i> 登录
                                </a>
                            </li>
                        <?php } else { ?>
                            <li>
                                <a href="<?= Url::to(['/site/logout']) ?>" data-method="post">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i> 注销
                                </a>
                            </li>
                        <?php } ?>
                    </ul>

                </nav>
            </div>

            <?php if (isset($this->params['breadcrumbs']) || isset($this->params['buttons'])) { ?>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-6">
                        <?php if (isset($this->params['breadcrumbs'])) { ?>
                            <h2><?= $this->title ?></h2>
                            <?= Breadcrumbs::widget([
                                'tag' => 'ol',
                                'activeItemTemplate' => "<li class=\"breadcrumb-item active\"><strong>{link}</strong></li>\n",
                                'links' => $this->params['breadcrumbs'] ?? [],
                            ]) ?>
                        <?php } ?>
                    </div>
                    <div class="col-lg-6">
                        <?php if (isset($this->params['buttons'])) { ?>
                            <div class="buttons">
                                <?php foreach ($this->params['buttons'] as $button) { ?>
                                    <?= Html::a($button['label'], $button['url'], $button['options']) ?>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

            <div class="wrapper wrapper-content animated fadeInRight">
                <?= $content ?>
            </div>

            <div class="footer <?= $this->params['footer']['class'] ?>">
                <div class="float-right">
                    <?= $this->params['footer']['right'] ?>
                </div>
                <div>
                    <?= $this->params['footer']['left'] ?>
                </div>
            </div>

        </div>
    </div>

    <?= Alert::widget() ?>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();