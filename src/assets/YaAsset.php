<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 02.03.2016
 */

namespace skeeks\cms\ya\map\assets;

use skeeks\cms\base\AssetBundle;
use yii\base\Event;
use yii\web\View;
/**
 * Class YaAsset
 * @package skeeks\cms\ya\map
 */
class YaAsset extends AssetBundle
{
    public $sourcePath = '@skeeks/cms/ya/map/assets/src';

    public $css = [];

    public $js = [
        //'//api-maps.yandex.ru/2.1/?load=package.full&lang=ru-RU',
    ];

    public $depends = [];


    public function registerAssetFiles($view)
    {
        if ($apiKey = \Yii::$app->yaMap->api_key) {
            if ($apiKey = \Yii::$app->yaMap->api_key) {
                \Yii::$app->view->registerJsFile("https://api-maps.yandex.ru/2.1/?apikey={$apiKey}&load=package.full&lang=ru-RU", ['position' => \yii\web\View::POS_END]);
            }
        } else {
            \Yii::$app->view->registerJsFile("//api-maps.yandex.ru/2.1/?load=package.full&lang=ru-RU", ['position' => \yii\web\View::POS_END]);
        }

        parent::registerAssetFiles($view);
    }
}
