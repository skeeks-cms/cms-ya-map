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
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class YaMapComponent extends Component {

    /**
     * @var string
     */
    public $api_key = '';

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
                ],
                'string',
            ],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'api_key'   =>  'Ключ api yandex карт',
        ]);
    }


    public function attributeHints()
    {
        return ArrayHelper::merge(parent::attributeHints(), [
            'api_key'   =>  'https://tech.yandex.ru/maps/jsapi/doc/2.1/quick-start/index-docpage/',
        ]);
    }

    /**
     * @return array
     */
    public function getConfigFormFields()
    {
        return [
            'api_key'
        ];
    }
}