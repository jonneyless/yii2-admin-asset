<?php

namespace ijony\admin\widgets;

use Yii;
use yii\web\View;

/**
 * Alert widget renders a message from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * ```php
 * Yii::$app->session->setFlash('error', 'This is the message');
 * Yii::$app->session->setFlash('success', 'This is the message');
 * Yii::$app->session->setFlash('info', 'This is the message');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * Yii::$app->session->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 */
class Alert extends \yii\bootstrap\Widget
{

    public $alertTypes = [
        'error',
        'success',
        'info',
        'warning'
    ];

    public function init()
    {
        parent::init();

        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();
        $js = [];

        foreach ($flashes as $type => $data) {
            if(!in_array($type, $this->alertTypes)){
                $type = 'info';
            }
            $data = (array) $data;
            foreach ($data as $message) {
                $message = str_replace('\'', '&apos;', $message);
                $js[] = <<<JS
toastr.$type('$message');
JS;
            }

            $session->removeFlash($type);
        }

        Yii::$app->getView()->registerJs(join("\n", $js), View::POS_READY, 'toastr');
    }
}
