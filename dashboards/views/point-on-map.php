<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 01.11.2015
 */
/* @var $this yii\web\View */
/* @var $widget \skeeks\cms\shop\dashboards\ReportOrderDashboard */
?>
<? $yaMap = \skeeks\cms\ya\map\widgets\YaMapWidget::begin($widget->getOptionsForYaMap()); ?>
<? \skeeks\cms\ya\map\widgets\YaMapWidget::end(); ?>