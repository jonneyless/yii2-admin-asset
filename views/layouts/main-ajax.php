<?php

/* @var $this \yii\web\View */
/* @var $content string */
?>
<?php $this->beginPage() ?>
<?php $this->head() ?>
<?php $this->beginBody() ?>
<?= $content ?>
<?php $this->endBody() ?>
<?php $this->endPage(true) ?>