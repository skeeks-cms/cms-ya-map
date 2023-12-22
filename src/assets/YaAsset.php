<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 02.03.2016
 */

namespace skeeks\cms\ya\map\assets;

use skeeks\cms\base\AssetBundle;
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

        $query = [
            'load' => 'package.full',
            'lang' => 'ru-RU',
        ];

        if ($apiKey = \Yii::$app->yaMap->api_key) {
            $query['apikey'] = $apiKey;
        }
        if ($suggest_apikey = \Yii::$app->yaMap->suggest_apikey) {
            $query['suggest_apikey'] = $suggest_apikey;
        }

        $url = "https://api-maps.yandex.ru/2.1/?" . http_build_query($query);

        \Yii::$app->view->registerJsFile($url, ['position' => \yii\web\View::POS_END]);

        parent::registerAssetFiles($view);
    }
}
