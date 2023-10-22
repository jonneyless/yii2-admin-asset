<?php

namespace ijony\admin\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;

/**
 * A Bootstrap 3 enhanced version of [[\yii\widgets\ActiveForm]].
 *
 * This class mainly adds the [[layout]] property to choose a Bootstrap 3 form layout.
 * So for example to render a horizontal form you would:
 *
 * ```php
 * use ijony\admin\widgets\ActiveForm;
 *
 * $form = ActiveForm::begin(['layout' => 'horizontal'])
 * ```
 *
 * This will set default values for the [[ActiveField]]
 * to render horizontal form fields. In particular the [[ActiveField::template|template]]
 * is set to `{label} {beginWrapper} {input} {error} {endWrapper} {hint}` and the
 * [[ActiveField::horizontalCssClasses|horizontalCssClasses]] are set to:
 *
 * ```php
 * [
 *     'offset' => 'col-sm-offset-3',
 *     'label' => 'col-sm-3',
 *     'wrapper' => 'col-sm-6',
 *     'error' => '',
 *     'hint' => 'col-sm-3',
 * ]
 * ```
 *
 * To get a different column layout in horizontal mode you can modify those options
 * through [[fieldConfig]]:
 *
 * ```php
 * $form = ActiveForm::begin([
 *     'layout' => 'horizontal',
 *     'fieldConfig' => [
 *         'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
 *         'horizontalCssClasses' => [
 *             'label' => 'col-sm-4',
 *             'offset' => 'col-sm-offset-4',
 *             'wrapper' => 'col-sm-8',
 *             'error' => '',
 *             'hint' => '',
 *         ],
 *     ],
 * ]);
 * ```
 *
 * @see ActiveField for details on the [[fieldConfig]] options
 * @see http://getbootstrap.com/css/#forms
 *
 * @author Michael Härtl <haertl.mike@gmail.com>
 * @since 2.0
 */
class ActiveForm extends \yii\bootstrap4\ActiveForm
{
    /**
     * @var string the default field class name when calling [[field()]] to create a new field.
     * @see fieldConfig
     */
    public $fieldClass = ActiveField::class;

    /**
     * @var array HTML attributes for the form tag. Default is `[]`.
     */
    public $options = [];

    /**
     * @var string the form layout. Either 'default', 'horizontal' or 'inline'.
     * By choosing a layout, an appropriate default field configuration is applied. This will
     * render the form fields with slightly different markup for each layout. You can
     * override these defaults through [[fieldConfig]].
     * @see \yii\bootstrap4\ActiveField for details on Bootstrap 3 field configuration
     */
    public $layout = 'horizontal';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if (!in_array($this->layout, [self::LAYOUT_DEFAULT, self::LAYOUT_HORIZONTAL, self::LAYOUT_INLINE])) {
            throw new InvalidConfigException('Invalid layout type: ' . $this->layout);
        }

        if ($this->layout !== self::LAYOUT_DEFAULT) {
            Html::addCssClass($this->options, 'form-' . $this->layout);
        }

        if ($this->layout == self::LAYOUT_HORIZONTAL && !$this->fieldConfig) {
            $this->fieldConfig = [
                'inline' => true,
                'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                'horizontalCssClasses' => [
                    'label' => 'col-sm-2 col-form-label',
                    'offset' => 'offset-sm-2',
                    'wrapper' => 'col-sm-10',
                    'error' => '',
                    'hint' => '',
                ],
            ];
        }

        parent::init();
    }

    /**
     * {@inheritdoc}
     * @return \yii\bootstrap4\ActiveField|\ijony\admin\widgets\ActiveField
     */
    public function field($model, $attribute, $options = [])
    {
        $error = $model->getFirstError($attribute);
        if ($error) {
            Yii::$app->session->addFlash('error', $error);
        }

        $inputName = Html::getInputName($model, $attribute);
        preg_match(Html::$attributeRegex, $attribute, $matches);
        if (isset($options['suffix'])) {
            $options['inputOptions']['id'] = Html::getInputId($model, $attribute) . '_' . rand(10000, 9999);
            $options['inputOptions']['name'] = $inputName . $options['suffix'];
            unset($options['suffix']);
        }

        if (is_string($options)) {
            if ($this->layout == self::LAYOUT_DEFAULT) {
                $this->fieldConfig['options']['class'] = 'form-group ' . $options;
            }

            $options = [];
        }

        if (isset($options['class'])) {
            if ($this->layout == 'horizontal') {
                $options['horizontalCssClasses'] = ArrayHelper::merge([
                    'label' => 'col-sm-2 col-form-label',
                    'offset' => 'offset-sm-2',
                    'wrapper' => 'col-sm-10',
                    'error' => '',
                    'hint' => '',
                ], $options['class']);
            }

            unset($options['class']);
        }

        return parent::field($model, $attribute, $options);
    }
}