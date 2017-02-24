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
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * Class YaMap
 * @package skeeks\cms\ya\map\related
 */
class YaMap extends PropertyType
{
    public $code = self::CODE_STRING;
    public $name = "";

    public $height  = 400; //px
    public $zoom    = 10; //px


    public $updateLatName           = '';
    public $updateLonName           = '';
    public $updateAddressName       = '';


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
            'height'                => "Высота карты",
            'zoom'                  => "Приближение карты",
            'updateLatName'         => "Обновлять latitude",
            'updateLonName'         => "Обновлять longitude",
            'updateAddressName'     => "Обновлять поле адрес",
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),
        [
            ['height', 'integer'],
            ['zoom', 'integer'],
            ['updateLatName', 'string'],
            ['updateLonName', 'string'],
            ['updateAddressName', 'string'],
        ]);
    }
    /**
     * @return string
     */
    public function renderConfigForm(ActiveForm $activeForm)
    {
        echo $activeForm->field($this, 'height');
        echo $activeForm->field($this, 'zoom');
        echo $activeForm->field($this, 'updateLatName');
        echo $activeForm->field($this, 'updateLonName');
        echo $activeForm->field($this, 'updateAddressName');
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
                        'zoom' => $this->zoom
                    ]
                ]
            ]
        ]);

        $opts['updateLatId'] = '';
        if ($this->updateLatName)
        {
            $opts['updateLatId'] = Html::getInputId($this->property->relatedPropertiesModel, $this->updateLatName);
        }

        $opts['updateLonId'] = '';
        if ($this->updateLonName)
        {
            $opts['updateLonId'] = Html::getInputId($this->property->relatedPropertiesModel, $this->updateLonName);
        }

        $opts['updateAddressId'] = '';
        if ($this->updateAddressName)
        {
            $opts['updateAddressId'] = Html::getInputId($this->property->relatedPropertiesModel, $this->updateAddressName);
        }

        $opts['mapId'] = $mapId;

        $js = \yii\helpers\Json::encode($opts);

        \Yii::$app->view->registerJs(<<<JS

(function(sx, $, _)
{
    sx.classes.YaInputRelatUpdater = sx.classes.Component.extend({

        _init: function()
        {
            var self = this;
            var mapId = this.get('mapId');
            sx.yaMaps.get(mapId).bind('select', function(e, data)
            {
                self.updateData(data);
            });
        },

        updateData: function(data)
        {
            if (this.get('updateLatId'))
            {
                var Jq = $('#' + this.get('updateLatId'));
                if (Jq.length)
                {
                    Jq.val(data.coords[0]);
                }
            }

            if (this.get('updateLonId'))
            {
                var Jq = $('#' + this.get('updateLonId'));
                if (Jq.length)
                {
                    Jq.val(data.coords[1]);
                }
            }

            if (this.get('updateAddressId'))
            {
                var Jq = $('#' + this.get('updateAddressId'));
                if (Jq.length)
                {
                    Jq.val(data.address);
                }
            }
        }
    });

    new sx.classes.YaInputRelatUpdater({$js});

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
