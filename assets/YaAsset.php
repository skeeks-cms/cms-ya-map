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
    public $sourcePath = '@skeeks/cms/ya/map/assets';

    public $css = [];

    public $js =
    [
        '//api-maps.yandex.ru/2.1/?load=package.full&lang=ru-RU',
    ];

    public $depends = [];
}
