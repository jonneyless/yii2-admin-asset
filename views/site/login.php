<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap5\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use ijony\admin\widgets\Alert;

$this->title = '登录';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginContent('@app/views/layouts/main-full.php');?>
    <div class="middle-box loginscreen">
        <div>
            <div>
                <h1 class="logo-name">登录</h1>
            </div>
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'm-t'],
            ]); ?>
                <?= $form->field($model, 'username')->label(false)->textInput(['autofocus' => true, 'placeholder' => '账 号']) ?>
                <?= $form->field($model, 'password')->label(false)->passwordInput(['placeholder' => '密 码']) ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <?= Html::submitButton('登录', ['class' => 'btn btn-primary block full-width m-b', 'name' => 'login-button']) ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <?= Alert::widget() ?>
<?php $this->endContent();?>
