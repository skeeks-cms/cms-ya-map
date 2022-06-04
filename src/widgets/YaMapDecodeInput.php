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
 * \skeeks\cms\ya\map\widgets\YaMapInput::widget([
        'name'      => 'yandex',
        'YaMapWidgetOptions' =>
        [
            'options' =>
            [
                'style' => 'height: 400px;'
            ]
        ],

        'clientOptions' =>
            [
                'select'    => new \yii\web\JsExpression(<<<JS
        function(e, data)
        {
            var lat = data.coords[0];
            var long = data.coords[1];
            var address = data.address;

            $('#appoffice-address').val(address);
            $('#appoffice-latitude').val(lat);
            $('#appoffice-longitude').val(long);
        }
JS
    )
            ]
    ]);
 *
 * @property string $yaMapId;
 *
 * @package skeeks\cms\ya\map\related
 */
class YaMapDecodeInput extends InputWidget
{
    /**
     * @var array опции контейнера
     */
    public $options   = [];

    public $elementOptions   = [];

    public $mapHeight = "400px;";

    public $isOpenedMap = false;

    //Можно указать атрибуты модели дли их автозаполениня
    public $modelLongitudeAttr = "";
    public $modelLatitudeAttr = "";


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

        Html::addCssClass($this->options, 'form-control');
        if (!isset($this->options['placeholder'])) {
            $this->options['placeholder'] = "Начните вводить адрес";
        }
    }

    public function getYaMapId() {
        return $this->id . "-map";
    }

    /**
	 * @inheritdoc
	 */
	public function run()
	{
        $value = '';
        $input = $this->renderInputHtml("text");

        $this->clientOptions['id'] = $this->options['id'];
        $this->clientOptions['yaMapId'] = $this->yaMapId;
        $this->clientOptions['isOpenedMap'] = (int) $this->isOpenedMap;

        if ($this->modelLatitudeAttr) {
            $this->clientOptions['latitude_element'] = Html::getInputId($this->model, $this->modelLatitudeAttr);
        }
        if ($this->modelLongitudeAttr) {
            $this->clientOptions['longitude_element'] = Html::getInputId($this->model, $this->modelLongitudeAttr);
        }


        return $this->render('ya-map-decode-input', [
            'input'     => $input,
        ]);
	}



}