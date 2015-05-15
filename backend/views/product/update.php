<?php
/* @var $this yii\web\View */
/* @var $model common\models\Product */
$this->title = 'Редактировать продукт №'. $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="product-update">
  <?= $this->render('_form', [
    'model' => $model,
    'categories' => $categories,
  ]) ?>
</div>
