<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 02.03.2016
 */
namespace skeeks\cms\ya\map\widgets;

use skeeks\cms\ya\map\assets\YaMapInputAsset;
use yii\helpers\Html;
use yii\widgets\InputWidget;

/**
 * <?= \skeeks\cms\ya\map\widgets\YaMapInput::widget([
        'name' => 'coord',
        'YaMapWidgetOptions' =>
        [
            'options' =>
            [
                'class' => 'sx-map'
            ]
        ]
    ]); ?>
 *
 *
 *
 * Class YaMap
 * @package skeeks\cms\ya\map\related
 */
class YaMapInput extends InputWidget
{
    /**
     * @var array опции контейнера
     */
    public $options   = [];

    /**
     * @see YaMapWidget
     * @var array Опции для yandex виджета
     */
    public $YaMapWidgetOptions   = [];

    /**
     * @var array
     */
    public $clientOptions   = [];

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $this->options['id'] = $this->id;
    }


    /**
	 * @inheritdoc
	 */
	public function run()
	{
        $inputId = $this->id . "-input";

        $this->clientOptions['inputId'] = $inputId;

        $value = '';
        if ($this->hasModel())
        {
			$input = Html::activeHiddenInput($this->model, $this->attribute);
            $this->clientOptions['inputId'] = Html::getInputId($this->model, $this->attribute);
            $value = Html::getAttributeValue($this->model, $this->attribute);

		} else
        {
            $input = Html::hiddenInput($this->name, $this->value, [
                'id' => $inputId
            ]);
		}

        if ($value)
        {
            $coords = explode(',', $value);
            $coords = [
                (float) $coords[0], (float) $coords[1]
            ];
            $this->YaMapWidgetOptions['clientOptions']['ya']['center'] = $coords;
        }


        $this->clientOptions['startPoint'] = $coords;

        return $this->render('ya-map-input', [
            'input'     => $input,
        ]);
	}



}