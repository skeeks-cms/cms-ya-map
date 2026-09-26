<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */

namespace skeeks\cms\ya\map;

use skeeks\cms\assets\CmsAsset;
use skeeks\cms\base\Component;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class YaMapComponent extends Component
{

    /**
     * @var string
     */
    public $api_key = '';
    public $suggest_apikey = '';
    /**
     * @var string Ключ продукта «API Геокодера». Яндекс вынес геокодер из ключа JavaScript API в отдельный продукт.
     */
    public $geocoder_apikey = '';

    /**
     * Можно задать название и описание компонента
     * @return array
     */
    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name' => 'Настройки yandex карты',
            'image'         => [
                CmsAsset::class,
                'images/icons/admin-menu/map.svg'
            ],
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [
                [
                    'api_key',
                    'suggest_apikey',
                    'geocoder_apikey',
                ],
                'string',
            ],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'api_key' => 'Ключ JavaScript API',
            'suggest_apikey' => 'Ключ API Геосаджеста',
            'geocoder_apikey' => 'Ключ API Геокодера',
        ]);
    }


    public function attributeHints()
    {
        return ArrayHelper::merge(parent::attributeHints(), [
            'api_key' => 'Основной ключ для работы карты. <br />Получить ключ api ключи можно тут: <a href="https://developer.tech.yandex.ru/services" target="_blank" data-pjax="0">https://developer.tech.yandex.ru/services</a>',
            'suggest_apikey' => 'Ключ для работы подсказок при вводе адреса',
            'geocoder_apikey' => 'Ключ для определения координат по адресу и адреса по точке на карте. <br />Если не указан, используется ключ JavaScript API, но у новых ключей Яндекса геокодер в него не входит.',
        ]);
    }

    /**
     * @return array
     */
    public function getConfigFormFields()
    {
        return [
            'api_key',
            'suggest_apikey',
            'geocoder_apikey',
        ];
    }

    /**
     * Создать адрес для декодированяи по данным
     * 
     * @see https://yandex.ru/dev/maps/geocoder/doc/desc/concepts/input_params.html;
     * @return string
     */
    public function createDecodeUrl($data = [])
    {
        $data['format'] = "json";
        $data['apikey'] = $this->getGeocoderApiKey();

        return "https://geocode-maps.yandex.ru/1.x/?" . http_build_query($data);
    }

    /**
     * Создать адрес для декодированяи по данным
     *
     * @see https://yandex.ru/dev/maps/geosearch/?from=mapsapi
     * @return string
     */
    public function createOrganizationUrl($data = [])
    {
        $baseData['format'] = "json";
        $baseData['apikey'] = $this->api_key;

        $data = ArrayHelper::merge($baseData, $data);

        return "https://search-maps.yandex.ru/v1/?" . http_build_query($data);
    }

    /**
     * Ключ для HTTP Геокодера: отдельный ключ API Геокодера, а если его нет — ключ JavaScript API
     *
     * @return string
     */
    public function getGeocoderApiKey()
    {
        return $this->geocoder_apikey ?: $this->api_key;
    }

    /**
     * Создать адрес для декодированяи по адресу
     * 
     * @param string $address
     * @return string
     */
    public function createDecodeUrlByAddress(string $address)
    {
        $data['geocode'] = $address;

        return $this->createDecodeUrl($data);
    }

}
