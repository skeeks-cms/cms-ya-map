<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 02.03.2016
 */
/* @var $this yii\web\View */
/* @var $widget \skeeks\cms\ya\map\widgets\YaMapWidget */
$widget = $this->context;
?>
<?= \yii\helpers\Html::tag('div', '', $widget->options); ?>

<?
$jsOptions = \yii\helpers\Json::encode($widget->clientOptions);
$this->registerJs(<<<JS
(function(sx, $, _)
{
    new sx.classes.ya.MapObject('{$widget->id}', {$jsOptions});
})(sx, sx.$, sx._);
JS
);
?>
