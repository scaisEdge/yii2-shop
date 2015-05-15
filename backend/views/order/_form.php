<?php

use common\models\Order;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <h1>
      <?= Html::encode($this->title) ?>
      <?= Html::submitButton($model->isNewRecord ? '<i class="mdi-action-done"></i>' : '<i class="mdi-action-done"></i>',
        [
          'class' => $model->isNewRecord ? 'btn btn-save pull-right' : 'btn btn-save pull-right',
          'data-toggle'=>'tooltip' ,
          'data-placement'=>'bottom',
          'title'=> $model->isNewRecord ? 'Добавить' : 'Сохранить',
        ]) ?>
    </h1>

    <table class="table table-hover">
      <thead><tr><th colspan="2"></th></tr></thead>
      <tbody>
        <tr><td>Статус</td><td><?= $form->field($model, 'status')->dropDownList([Order::getStatuses()])->label(false) ?></td></tr>
        <tr><td>Заметка</td><td><?= $form->field($model, 'notes')->textarea(['rows' => 4])->label(false) ?></td></tr>
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
      <tr><td>Телефон</td><td><?= $form->field($model, 'phone')->textInput(['maxlength' => 255])->label(false) ?></td></tr>
      <tr><td>E-mail</td><td><?= $form->field($model, 'email')->textInput(['maxlength' => 255])->label(false) ?></td></tr>
      </tbody>
    </table>
  <?php ActiveForm::end(); ?>

  <?php \yii\widgets\Pjax::begin(['timeout' => 10000,'clientOptions' => ['container' => 'pjax-container']]); ?>
    <?php $form = ActiveForm::begin(); ?>
      <h1 style="margin-bottom: 15px">Товары</h1>
      <table class="table table-hover table-bordered">
        <thead><tr>
          <th class="text-center">№</th>
          <th class="text-center">Код</th>
          <th>Наименование товара</th>
          <th class="text-center">Цена</th>
          <th>Кол-во</th>
          <th></th>
        </tr></thead>
        <tbody>
        <?php $n=1; $tq=0; $tp=0; if (!empty($model->orderItems)) {
          foreach ($model->orderItems as $item) { ?>
          <tr>
            <td class="text-center"><?= $n ; $n++ ?></td>
            <td class="text-center"><?= $item->product_id ?></td>
            <td><?= Html::a( $item->title, ['/product/view', 'id' => $item->product_id]) ?></td>
            <td class="text-center"><?= $item->price ?></td>
            <td class="text-center"><?= $form->field($item, 'quantity')->textInput(['maxlength' => 255])->label(false) ?></td>
            <td><?= Html::a('<i class="mdi-action-delete"></i>', ['delete-item', 'id' => $item->id], [
              'class' => 'btn btn-delete pull-right hidden-print',
              'data-toggle'=>'tooltip' ,
              'data-placement'=>'bottom',
              'title'=>'Удалить',
              'data' => [
                'confirm' => 'Вы уверены что хотите удалить этот продукт из заказа?',
                'method' => 'post',
              ],
            ]) ?></td>
          </tr>
        <?php } } ?>

<!--        <tr>-->
<!--          <td>--><?//= $n ?><!--</td>-->
<!--          <td>--><?//= $bbb = $form->field($item, 'id')->textInput()->label(false) ?><!--</td>-->
<!--          <td></td>-->
<!--          <td></td>-->
<!--          <td class="text-center">--><?//= $form->field($product, 'quantity')->textInput()->label(false) ?><!--</td>-->
<!--          <td>--><?//= Html::a('<i class="mdi-action-done"></i>', ['add-item', 'id' => $bbb], [
//              'class' => 'btn btn-add pull-right',
//              'data-toggle'=>'tooltip' ,
//              'data-placement'=>'bottom',
//              'title'=>'Добавить товар',
//            ]) ?><!--</td>-->
<!--        </tr>-->

        </tbody>
      </table>
    <?php ActiveForm::end(); ?>
  <?php \yii\widgets\Pjax::end(); ?>





</div>
