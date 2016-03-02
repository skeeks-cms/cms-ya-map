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
use yii\helpers\ArrayHelper;

/**
 * Class YaMap
 * @package skeeks\cms\ya\map\related
 */
class YaMap extends PropertyType
{
    public $code = self::CODE_STRING;
    public $name = "";

    public function init()
    {
        parent::init();

        if(!$this->name)
        {
            $this->name = \Yii::t('app', 'Yandex map');
        }
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),
        [
            'type'  => \Yii::t('app', 'Type'),
        ]);
    }

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(),
        [

        ]);
    }

    /**
     * @return \yii\widgets\ActiveField
     */
    public function renderForActiveForm()
    {
        $field = parent::renderForActiveForm();

        $field->widget(\skeeks\cms\modules\admin\widgets\formInputs\OneImage::className(),
        [
            'filesModel' => $this->model
        ]);

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