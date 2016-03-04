Виджеты для работы с Yandex картами
===================================
##SkeekS CMS Marketplace

http://marketplace.cms.skeeks.com/solutions/instrumentyi/razrabotchiku/228-cms-ya-map

##Exemples

#### simple
```php
<?= \skeeks\cms\ya\map\widgets\YaMapWidget::widget([
    'options' =>
    [
        'class' => 'sx-map'
    ]
]) ?>
```

#### or

```php
<? $yaMap = \skeeks\cms\ya\map\widgets\YaMapWidget::begin([
    'options' =>
    [
        'class' => 'sx-map'
    ]
]) ?>
    <? $yaMap->setZoom(5)->setCenter(); ?>
<? \skeeks\cms\ya\map\widgets\YaMapWidget::end() ?>
```

#### advanced

```php
<? $yaMap = \skeeks\cms\ya\map\widgets\YaMapWidget::begin([
    'options' =>
    [
        'class' => 'sx-map'
    ],
    'clientOptions' =>
    [
        'onReady' => new \yii\web\JsExpression(<<<JS
            function(e, YaMap){
                console.log(YaMap);
            }
JS
)
    ],
]) ?>
    <? $yaMap->setZoom(5)->setCenter(); ?>
<? \skeeks\cms\ya\map\widgets\YaMapWidget::end() ?>
```

___
> [![skeeks!](https://gravatar.com/userimage/74431132/13d04d83218593564422770b616e5622.jpg)](http://skeeks.com)
<i>SkeekS CMS (Yii2) — быстро, просто, эффективно!</i>
[skeeks.com](http://skeeks.com) | [cms.skeeks.com](http://cms.skeeks.com) | [marketplace.cms.skeeks.com](http://marketplace.cms.skeeks.com)

