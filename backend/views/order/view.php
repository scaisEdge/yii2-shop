<?php

use common\components\SetFormat;
use common\models\OrderItem;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = Yii::$app->name.' Заказ №'.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = '№'.$model->id;
?>
<div class="order-view">

  <h1>
    Заказ №<?= $model->id ?>
    <?= Html::a('<i class="mdi-action-delete"></i>', ['delete', 'id' => $model->id], [
      'class' => 'btn btn-delete pull-right hidden-print',
      'data-toggle'=>'tooltip' ,
      'data-placement'=>'bottom',
      'title'=>'Удалить',
      'data-confirm' => Yii::t('yii', 'Вы уверены что хотите удалить этот заказ?'),
      'data-method'=>'post',
    ]) ?>

    <a type="button"
       class="btn-print pull-right hidden-print"
       onclick="window.print();return false;"
       data-toggle="tooltip"
       data-placement="bottom"
       title="Распечатать"><i class="mdi-action-print"></i></a>

    <?= Html::a('<i class="mdi-editor-mode-edit"></i>', ['update', 'id' => $model->id], [
      'class' => 'btn btn-save pull-right hidden-print',
      'data-toggle'=>'tooltip' ,
      'data-placement'=>'bottom',
      'title'=>'Редактировать',
    ]) ?>
  </h1>

  <table class="table table-hover">
    <thead>
      <tr>
        <th colspan="2"></th>
      </tr>
    </thead>
    <tbody>
      <tr><td>Статус</td><td><?= $model->status ?></td></tr>
      <tr><td>Дата поступления</td><td><?= SetFormat::convert($model->created_at, 'datetime') ?></td></tr>
<!--      <tr><td>Дата последнего обновления</td><td>--><?//= SetDTFormat::convert($model->updated_at, 'datetime') ?><!--</td></tr>-->
      <tr class="hidden-print"><td>Заметка</td><td><?= $model->notes ?></td></tr>
    </tbody>
  </table>

  <h1 style="margin-bottom: 15px">Товары</h1>
  <table class="table table-hover table-bordered">
    <thead><tr>
      <th class="text-center">№</th>
      <th class="text-center">Код</th>
      <th>Наименование товара</th>
      <th class="text-center">Цена</th>
      <th>Кол-во</th>
      <th class="text-center">Сумма</th>
    </tr></thead>
    <tbody>
    <?php $n=1; $tq=0; $tp=0 ;foreach ($model->orderItems as $item) {
      $pq = $item->price * $item->quantity ?>
      <tr>
        <td class="text-center"><?= $n ; $n++ ?></td>
        <td class="text-center"><?= $item->product_id ?></td>
        <td><?= Html::a( $item->title, ['/product/view', 'id' => $item->product_id]) ?></td>
        <td class="text-center"><?= $item->price ?></td>
        <td class="text-center"><?= $item->quantity; $tq+=$item->quantity ?></td>
        <td class="text-center"><?= $pq; $tp+=$pq ?></td>
      </tr>
    <?php } ?>
    <tr>
      <td colspan="3"></td>
      <td class="text-center"><b>Итого:</b></td>
      <td class="text-center"><b><?= $tq ?></b></td>
      <td class="text-center"><b><?= $tp ?></b></td>
    </tr>
    </tbody>
  </table>

  <h1>Данные заказчика</h1>
  <table class="table table-hover">
    <thead>
      <tr>
        <th colspan="2"></th>
      </tr>
    </thead>
    <tbody>
      <tr><td>Телефон</td><td><?= $model->phone ?></td></tr>
      <tr><td>E-mail</td><td><?= $model->email ?></td></tr>
    </tbody>
  </table>

</div>
