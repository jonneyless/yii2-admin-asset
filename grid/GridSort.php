<?php

namespace ijony\admin\grid;

use ijony\helpers\Image;
use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\JuiAsset;
use yii\web\View;

class GridSort extends \yii\grid\GridView
{

    public $dataUrl = '';

    public $options = ['class' => 'ibox-content'];

    public $tableOptions = ['class' => 'table table-striped'];

    public $layout = "{items}";

    public function init()
    {
        parent::init();

        if (!$this->dataUrl) {
            throw new InvalidConfigException('The "dataUrl" property must be either a Url string or a Url array data.');
        }

        if (is_array($this->dataUrl)) {
            $this->dataUrl = Url::to($this->dataUrl);
        }
    }

    public function run()
    {
        parent::run();
        $view = $this->getView();

        if ($pager = $this->renderPager()) {
            $view->params['footer']['left'] = $pager;
            $view->params['footer']['class'] = 'footer-fixed';
        }

        $view->params['footer']['right'] = $this->renderSummary();

        $js = <<<JS

$('#grid-sort').sortable({
    items: ".sort-item",
    cursor: "move",
    containment: "parent",
    update: function(event, ui){
        var sortData = $('#sort-form').serialize();
        
        $.post('{$this->dataUrl}', sortData);
    }
});

JS;

        Yii::$app->getView()->registerJs($js, View::POS_READY, 'grid-sort');
        JuiAsset::register(Yii::$app->getView());
    }

    /**
     * Renders the data models for the grid view.
     */
    public function renderItems()
    {
        $models = array_values($this->dataProvider->getModels());

        $content = [];
        foreach ($models as $model) {
            $content[] = $this->renderItem($model);
        }

        $content = Html::tag('ul', implode("\n", $content), ['class' => 'grid-sort', 'id' => 'grid-sort']);

        return Html::tag('form', $content, ['id' => 'sort-form']);
    }

    /**
     * Creates column objects and initializes them.
     */
    protected function initColumns()
    {
        if (!isset($this->columns['image']) || !isset($this->columns['key'])) {
            throw new InvalidConfigException('The "image" "sort" and "key" property must be set in columns.');
        }
    }

    public function renderItem($model)
    {
        $key = $model->{$this->columns['key']};
        $image = $model->{$this->columns['image']};
        $content[] = <<<HTML
    <div class="grid-preview">
        <img src="$image" />
        <input type="hidden" name="sort[]" value="$key" />
    </div>
HTML;

        if (isset($this->columns['name'])) {
            $name = $model->{$this->columns['name']};
            $content[] = <<<HTML
    <div class="grid-name">$name</div>
HTML;
        }

        return Html::tag('li', implode("\n", $content), ['class' => 'sort-item']);
    }
}