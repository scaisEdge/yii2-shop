<?php
/* @var $this yii\web\View */
/* @var $model common\models\Product */
$this->title = 'Новый продукт';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">
  <?= $this->render('_form', [
    'model' => $model,
    'categories' => $categories,
  ]) ?>
</div>
