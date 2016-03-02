<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 02.03.2016
 */
namespace skeeks\cms\ya\map\related;

use skeeks\cms\components\Cms;
use skeeks\cms\relatedProperties\PropertyType;
use skeeks\cms\ya\map\widgets\YaMapInput;
use yii\helpers\ArrayHelper;

/**
 * Class YaMap
 * @package skeeks\cms\ya\map\related
 */
class YaMap extends PropertyType
{
    public $code = self::CODE_STRING;
    public $name = "";

    public $height  = 400; //px
    public $zomm    = 10; //px


    public $updateLat           = 0; //px
    public $updateLon           = 0; //px
    public $updateAddress       = 0; //px


    public function init()
    {
        parent::init();

        if(!$this->name)
        {
            $this->name = 'Yandex карта (выбор одной координаты)';
        }
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),
        [
            'height'  => "Высота карты",
            'zomm'  => "Пришлижение карты",
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),
        [
            ['height', 'integer'],
            ['zomm', 'integer']
        ]);
    }

    /**
     * @return \yii\widgets\ActiveField
     */
    public function renderForActiveForm()
    {
        $field = parent::renderForActiveForm();
        $mapId = 'sx-map-' . $field->attribute;

        $field->widget(YaMapInput::className(), [
            'YaMapWidgetOptions' =>
            [
                'id' => $mapId,
                'options' =>
                [
                    'style' => "height: {$this->height}px"
                ],
                'clientOptions' =>
                [
                    'ya' =>
                    [
                        'zomm' => $this->zomm
                    ]
                ]
            ]
        ]);

        \Yii::$app->view->registerJs(<<<JS

(function(sx, $, _)
{
    sx.yaMaps.get('{$mapId}').bind('select', function(e, data)
    {
        console.log(data);
    });
})(sx, sx.$, sx._);
JS
);

        return $field;
    }


    /**
     * Файл с формой настроек, по умолчанию лежит в той же папке где и компонент.
     *
     * @return string
     */
    public function getConfigFormFile()
    {
        $class = new \ReflectionClass($this->className());
        return dirname($class->getFileName()) . DIRECTORY_SEPARATOR . 'views/_formYaMap.php';
    }
}