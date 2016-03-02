<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 25.05.2015
 */

namespace skeeks\cms\ya\map\dashboards;

use skeeks\cms\base\Widget;
use skeeks\cms\base\WidgetRenderable;
use skeeks\cms\helpers\UrlHelper;
use skeeks\cms\modules\admin\base\AdminDashboardWidget;
use skeeks\cms\modules\admin\base\AdminDashboardWidgetRenderable;
use skeeks\cms\ya\map\widgets\YaMapInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\ActiveForm;

/**
 * Class PointOnMap
 * @package skeeks\cms\ya\map\dashboards
 */
class PointOnMap extends AdminDashboardWidgetRenderable
{
    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name' => "Точка на карте"
        ]);
    }

    public $viewFile = 'point-on-map';
    public $name;
    public $point;
    public $height = 400;

    public $zoom = 10;

    public function init()
    {
        parent::init();

        if (!$this->name)
        {
            $this->name = "Координаты на карте";
        }
    }

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['name'], 'string'],
            [['point'], 'string'],
            [['zoom'], 'integer'],
            [['height'], 'integer'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'name'                           => \Yii::t('app', 'Name'),
            'height'                         => "Высота карты",
            'zoom'                           => "Увеличение карты",
            'point'                          => "Точка на карте",
        ]);
    }

    public function getOptionsForYaMap()
    {
        return [
            'options' =>
            [
                'style' => "height: {$this->height}px;"
            ],
            'clientOptions' =>
            [
                'zoom' => $this->zoom,
            ]
        ];
    }

    /**
     * @param ActiveForm $form
     */
    public function renderConfigForm(ActiveForm $form = null)
    {
        echo $form->field($this, 'name');
        echo $form->field($this, 'zoom');
        echo $form->field($this, 'height');
        echo $form->field($this, 'point')->widget(YaMapInput::className());
    }
}