<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */

namespace skeeks\cms\ya\map;

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
     * Можно задать название и описание компонента
     * @return array
     */
    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name' => 'Настройки yandex карты',
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [
                [
                    'api_key',
                    'suggest_apikey',
                ],
                'string',
            ],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'api_key' => 'Ключ JavaScript API и HTTP Геокодер',
            'suggest_apikey' => 'Ключ API Геосаджеста',
        ]);
    }


    public function attributeHints()
    {
        return ArrayHelper::merge(parent::attributeHints(), [
            'api_key' => 'Основной ключ для работы карты. <br />Получить ключ api ключи можно тут: <a href="https://developer.tech.yandex.ru/services" target="_blank" data-pjax="0">https://developer.tech.yandex.ru/services</a>',
            'suggest_apikey' => 'Ключ для работы подсказок при вводе адреса',
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
        $data['apikey'] = $this->api_key;

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