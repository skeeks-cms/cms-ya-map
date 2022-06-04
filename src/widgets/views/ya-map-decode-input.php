<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 02.03.2016
 */
/* @var $this yii\web\View */
/* @var $widget \skeeks\cms\ya\map\widgets\YaMapDecodeInput */

\skeeks\cms\ya\map\assets\YaMapDecodeWidgetAsset::register($this);
$widget = $this->context;

?>

<?= \yii\helpers\Html::beginTag('div', ['class' => 'sx-ya-map-decode-input']); ?>
<div class="sx-input-decode-wrapper">
    <?= $input; ?>
    <input type="hidden" class="sx-hidden-input" />
    <div class="sx-trigger-show-map" data-open-text="Показать карту" data-close-text="Скрыть карту"></div>
</div>
<div class="sx-map-wrapper">
    <div id="<?php echo $widget->yaMapId; ?>"></div>
</div>
<?
$jsOptions = \yii\helpers\Json::encode($widget->clientOptions);
$this->registerCss(<<<CSS
#{$widget->yaMapId} {
    height: $widget->mapHeight;
}
.sx-map-wrapper {
    display: none;
}
.sx-input-decode-wrapper {
    position: relative;
}

.sx-trigger-show-map {
    position: absolute;
    right: 11px;
    top: 8px;
    cursor: pointer;
    border-bottom: 1px dashed;
    color: gray;
}
CSS
);
$this->registerJs(<<<JS
(function(sx, $, _)
{
    new sx.classes.YaMapDecodeWidget({$jsOptions});

})(sx, sx.$, sx._);
JS
); ?>
<?= \yii\helpers\Html::endTag('div'); ?>

