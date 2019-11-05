<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 02.03.2016
 */
namespace skeeks\cms\ya\map\assets;
/**
 * Class YaMapPluginChangeWithDelayAsset
 * @package skeeks\cms\ya\map\assets
 */
class YaMapPluginChangeWithDelayAsset extends YaAsset
{
    public $css = [];
    public $js =
    [
        'plugins/ya-change-with-delay.js',
    ];
    public $depends = [
        '\skeeks\cms\ya\map\assets\YaMapAsset',
    ];
}
