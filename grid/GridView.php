<?php

namespace ijony\admin\grid;

use ijony\admin\assets\FootableAsset;
use Yii;
use yii\helpers\Html;
use yii\web\View;

class GridView extends \yii\grid\GridView
{

    public $pager = [
        'pageCssClass' => 'paginate_button page-item',
        'linkOptions' => [
            'class' => 'page-link',
        ],
        'prevPageLabel' => '<i class="fa fa-angle-left"></i>',
        'nextPageLabel' => '<i class="fa fa-angle-right"></i>',
        'firstPageLabel' => '<i class="fa fa-angle-double-left"></i>',
        'lastPageLabel' => '<i class="fa fa-angle-double-right"></i>',
    ];

    public $layoutFix = true;

    public $footable = false;

    public $tableOptions = ['class' => 'table'];

    public $layout = "{items}";

    public function run()
    {
        if ($this->footable) {
            if ($this->tableOptions['class']) {
                $this->tableOptions['class'] .= ' table-footable';
            } else {
                $this->tableOptions['class'] = 'table-footable';
            }
        }

        if ($this->layoutFix) {
            if ($this->tableOptions['class']) {
                $this->tableOptions['class'] .= ' table-layout-fix';
            } else {
                $this->tableOptions['class'] = 'table-layout-fix';
            }
        }

        if (isset($this->options['class'])) {
            $this->options['class'] .= ' table-responsive';
        } else {
            $this->options['class'] = 'table-responsive';
        }

        parent::run();
        $view = $this->getView();

        if ($pager = $this->renderPager()) {
            $view->params['footer']['left'] = $pager;
            $view->params['footer']['class'] = 'footer-fixed';
        }

        $view->params['footer']['right'] = $this->renderSummary();

        if ($this->footable) {
            $js = <<<JS

$('.table-footable').footable();

JS;

            Yii::$app->getView()->registerJs($js, View::POS_READY, 'footable');
            FootableAsset::register(Yii::$app->getView());
        }
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

        return Html::tag('table', implode("\n", $content), $this->tableOptions);
    }
}