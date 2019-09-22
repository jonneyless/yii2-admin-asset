<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $message */

$delay = isset($delay) ? $delay : 3;
$url = isset($url) ? $url : Yii::$app->getUser()->getReturnUrl('/');

if(is_array($url)){
    $url = Url::to($url);
}

?>
<?php $this->beginContent('@app/views/layouts/main-full.php');?>
    <div class="middle-box" style="padding-top: 100px;">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="panel-title">系统提示</h2>
            </div>
            <div class="panel-body">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <p>&nbsp;</p>
                    <?php if(is_array($message)){ ?>
                        <ol style="line-height: 30px;">
                            <?php foreach($message as $msg){ ?>
                                <li><?php echo $msg; ?></li>
                            <?php } ?>
                        </ol>
                    <?php }else{ ?>
                        <p class="text-center"><?= nl2br(Html::encode($message)) ?></p>
                    <?php } ?>
                    <p>&nbsp;</p>
                    <?php if($delay > 0){ ?>
                        <p class="text-center gray">请稍等，<strong id="delay" class="red"><?php echo $delay; ?></strong> 秒后将自动跳转……</p>
                    <?php } ?>
                    <p class="text-center gray">点击<a class="pink" href="<?php echo $url; ?>">这里</a>直接跳转</p>
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var t;
        var delay = <?= $delay ?>;

        function toGo(){
            delay -= 1;
            if(delay == 0){
                window.location = "<?= $url ?>";
                return false;
            }
            document.getElementById('delay').innerText = delay;
            t = setTimeout("toGo()", 1000);
        }

        if(delay > 0){
            t = setTimeout("toGo()", 1000);
        }
    </script>
<?php $this->endContent();?>