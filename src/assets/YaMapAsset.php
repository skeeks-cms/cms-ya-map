<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 02.03.2016
 */
namespace skeeks\cms\ya\map\assets;
/**
 * Class YaAsset
 * @package skeeks\cms\ya\map
 */
class YaMapAsset extends YaAsset
{
    public $css = [];
    public $js =
    [
        'ya-map.js',
    ];
    public $depends = [
        '\skeeks\cms\ya\map\assets\YaAsset',
        '\skeeks\sx\assets\Core',
    ];
}
