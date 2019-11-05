<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 02.03.2016
 */
namespace skeeks\cms\ya\map\widgets;

use skeeks\cms\ya\map\assets\YaMapAsset;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

/**
 *
 * \skeeks\cms\ya\map\widgets\YaMapWidget::widget([
 *  'clientOptions' = [],   //js options
 *  'options' = [],         //div container options
 * ]);
 *
 * or
 *
 * <? $yaMap = \skeeks\cms\ya\map\widgets\YaMapWidget::begin([
        'options' =>
        [
            'class' => 'sx-map'
        ],
        'clientOptions' =>
        [
            'onReady' => new \yii\web\JsExpression(<<<JS
                function(e, YaMap){
                    console.log(YaMap);
                }
JS
)
        ],
    ]) ?>
        <? $yaMap->setZoom()->setCenter(); ?>
    <? \skeeks\cms\ya\map\widgets\YaMapWidget::end() ?>
 *
 * Class YaMap
 * @package skeeks\cms\ya\map\related
 */
class YaMapWidget extends Widget
{
    /**
     * @var array Опции для js
     */
    public $clientOptions   = [];

    /**
     * @var array Опции контейнера карты
     */
    public $options         = [];

    /**
     *
     */
    public function init()
    {
        $this->options['id'] = $this->id;

        //Обязательные опции по умолчанию.
        if (!isset($this->clientOptions['ya']['zoom']))
        {
            $this->setZoom();
        }

        if (!isset($this->clientOptions['ya']['center']))
        {
            $this->setCenter();
        }

        if (!isset($this->clientOptions['ya']['controls']))
        {
            $this->setControlls();
        }

    }

    /**
     * @param int $default
     * @return $this
     */
    public function setZoom($default = 10)
    {
        $this->clientOptions['ya']['zoom'] = $default;
        return $this;
    }

    /**
     * @param int $default
     * @return $this
     */
    public function setCenter($default = [55.75241746329202,37.62104013208003])
    {
        $this->clientOptions['ya']['center'] = $default;
        return $this;
    }
    /**
     * @param int $default
     * @return $this
     */
    public function setControlls($default = ['zoomControl', 'fullscreenControl', 'typeSelector', 'rulerControl', 'routeEditor'])
    {
        $this->clientOptions['ya']['controls'] = $default;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        YaMapAsset::register($this->view);
        return $this->render('ya-map');
    }

}