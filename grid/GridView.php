<?php

namespace ijony\admin\grid;

use ijony\admin\assets\FootableAsset;
use Yii;
use yii\helpers\Html;
use yii\web\View;

class GridView extends \yii\grid\GridView
{

    public $layoutFix = false;
    public $options = ['class' => 'ibox-content'];
    public $tableOptions = ['class' => 'table table-footable table-striped'];
    public $layout = "{items}";

    public function run()
    {
        if($this->layoutFix){
            if($this->tableOptions['class']){
                $this->tableOptions['class'] .= ' table-layout-fix';
            }else{
                $this->tableOptions['class'] = 'table-layout-fix';
            }
        }

        parent::run();
        $view = $this->getView();

        if($pager = $this->renderPager()){
            $view->params['footer']['left'] = $pager;
            $view->params['footer']['class'] = 'footer-fixed';
        }

        $view->params['footer']['right'] = $this->renderSummary();

//        $js = <<<JS
//
//$('.table-footable').footable();
//
//JS;
//
//        Yii::$app->getView()->registerJs($js, View::POS_READY, 'footable');
//        FootableAsset::register(Yii::$app->getView());
    }

    /**
     * Renders the data models for the grid view.
     */
    public function renderItems()
    {
        $caption = $this->renderCaption();
        $columnGroup = $this->renderColumnGroup();
        $tableHeader = $this->showHeader ? $this->renderTableHeader() : false;
        $tableBody = $this->renderTableBody();
        $tableFooter = $this->showFooter ? $this->renderTableFooter() : false;
        $content = array_filter([
            $caption,
            $columnGroup,
            $tableHeader,
            $tableFooter,
            $tableBody,
        ]);

        $table = Html::tag('table', implode("\n", $content), $this->tableOptions);

        return Html::tag('div', $table, ['class' => 'table-responsive']);
    }
}