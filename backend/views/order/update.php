<?php

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = 'Заказ '.'№'.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '№'.$model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="order-update">

  <?= $this->render('_form', [
    'model' => $model,
  ]) ?>

</div>
