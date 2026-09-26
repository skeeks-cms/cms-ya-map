<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */

namespace skeeks\cms\ya\map\assets;

use skeeks\cms\base\AssetBundle;
use yii\helpers\Json;
use yii\web\View;

/**
 * Геокодирование адресов и координат: sx.YaGeocoder.geocode()
 *
 * Если в компоненте задан ключ API Геокодера, запросы идут в HTTP Геокодер,
 * иначе через ymaps.geocode() с ключом JavaScript API.
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class YaGeocoderAsset extends AssetBundle
{
    public $sourcePath = '@skeeks/cms/ya/map/assets/src';

    public $css = [];

    public $js = [
        'ya-geocoder.js',
    ];

    public $depends = [
        '\skeeks\cms\ya\map\assets\YaAsset',
        '\skeeks\sx\assets\Core',
    ];

    public function registerAssetFiles($view)
    {
        parent::registerAssetFiles($view);

        $apikey = Json::encode((string)\Yii::$app->yaMap->geocoder_apikey);
        $view->registerJs("sx.YaGeocoder.apikey = {$apikey};", View::POS_END, self::class);
    }
}
