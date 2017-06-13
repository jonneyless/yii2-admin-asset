<?php

/* @var $this \yii\web\View */
/* @var $content string */

use ijony\admin\assets\AppAsset;
use ijony\admin\widgets\Sidebar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

AppAsset::register($this, $this->context->getPlugins());
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="jony">
    <link rel="icon" href="favicon.ico">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<?php $this->beginBody() ?>

<div id="wrapper">
    <?= Sidebar::widget([
        'items' => $this->context->getMenus()
    ]); ?>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom white-bg">
            <nav class="navbar navbar-static-top" role="navigation">
                <div class="navbar-header">
                    <a class="navbar-minimalize btn btn-primary" href="#" onclick="$('#wrapper').toggleClass('sidebar-toggle')"><i class="fa fa-bars"></i></a>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li class="no-small">欢迎使用后台系统。</li>
                    <li>
                        <a href="<?= Url::to(['site/logout']) ?>">
                            <i class="fa fa-sign-out" aria-hidden="true"></i> 注销
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <?php if(isset($this->params['breadcrumbs']) || isset($this->params['buttons'])){ ?>
        <div class="row border-bottom white-bg page-header">
            <div class="col-lg-6">
                <?php if(isset($this->params['breadcrumbs'])){ ?>
                <h2><?= $this->title ?></h2>
                <?= Breadcrumbs::widget([
                    'tag' => 'ol',
                    'activeItemTemplate' => "<li class=\"active\"><strong>{link}</strong></li>\n",
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?php } ?>
            </div>
            <div class="col-lg-6">
                <?php if(isset($this->params['buttons'])){ ?>
                <div class="buttons">
                    <?php foreach($this->params['buttons'] as $button){ ?>
                    <?= Html::a($button['label'], $button['url'], $button['options']) ?>
                    <?php } ?>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>

        <div class="wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <?= $content ?>
                </div>
            </div>
        </div>

        <div class="footer">
            <div class="pull-right no-small">
                <?= $this->params['footer']['right'] ?>
            </div>
            <div>
                <?= $this->params['footer']['left'] ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>