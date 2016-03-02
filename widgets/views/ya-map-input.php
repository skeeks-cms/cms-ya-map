<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 02.03.2016
 */
/* @var $this yii\web\View */
/* @var $widget \skeeks\cms\ya\map\widgets\YaMapInput */

\skeeks\cms\ya\map\assets\YaMapPluginGeocodeCoordsAsset::register($this);

$widget = $this->context;

?>

<?= \yii\helpers\Html::beginTag('div', $widget->options); ?>
        <?= $input; ?>

        <? $yaMap = \skeeks\cms\ya\map\widgets\YaMapWidget::begin($widget->YaMapWidgetOptions); ?>
        <? \skeeks\cms\ya\map\widgets\YaMapWidget::end(); ?>

<?
$widget->clientOptions['mapId'] = $yaMap->id;
$jsOptions = \yii\helpers\Json::encode($widget->clientOptions);


$this->registerJs(<<<JS
(function(sx, $, _)
{
    sx.classes.YaInput = sx.classes.Component.extend({

        _init: function()
        {
            var self = this;
            this.MapObject = sx.yaMaps.get(this.get('mapId'));
            this.Geocode = new sx.classes.ya.plugins.GeocodeCoords(this.MapObject);


            this.Geocode.bind('select', function(e, data)
            {
                var coords = data.coords;
                var coordsString = data.coords[0] + "," + data.coords[1];

                self.setInputValue(coordsString);

            });

            this.MapObject.onReady(function(MapObject)
            {
                if (self.get('startPoint'))
                {
                    console.log(self.get('startPoint'));
                    self.Geocode.setCoordinates(self.get('startPoint'));
                }
            });
        },

        setInputValue: function(value)
        {
            var self = this;
            $("#" + self.get('inputId')).val(value).change();

            return this;
        }
    });

    new sx.classes.YaInput({$jsOptions});

})(sx, sx.$, sx._);
JS
); ?>
<?= \yii\helpers\Html::endTag('div'); ?>

