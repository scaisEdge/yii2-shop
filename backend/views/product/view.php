<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerMetaTag(['name' => 'title', 'content'=>$model->mt]);
$this->registerMetaTag(['name' => 'description', 'content'=>$model->md]);
$this->registerMetaTag(['name' => 'keywords', 'content'=>$model->mk]);
?>
<div class="product-view">

  <h1>
    <?= Html::encode($this->title) ?>
    <?= Html::a('<i class="mdi-action-delete"></i>', ['delete', 'id' => $model->id], [
      'class' => 'btn btn-delete pull-right hidden-print',
      'data-toggle'=>'tooltip' ,
      'data-placement'=>'bottom',
      'title'=>'Удалить',
      'data' => [
        'confirm' => 'Вы уверены что хотите удалить этот продукт?',
        'method' => 'post',
      ],
    ]) ?>

    <?= Html::a('<span class="image mdi-image-camera-alt" aria-label="Image"></span>',
      Url::to(['image/index', 'id' => $model->id]),[
        'class' => 'btn btn-add pull-right',
        'data-toggle'=>'tooltip' ,
        'data-placement'=>'bottom',
        'title'=>'Фотографии',
      ]); ?>

    <?= Html::a('<i class="mdi-editor-mode-edit"></i>', ['update', 'id' => $model->id], [
      'class' => 'btn btn-save pull-right hidden-print',
      'data-toggle'=>'tooltip' ,
      'data-placement'=>'bottom',
      'title'=>'Редактировать',
    ]) ?>
  </h1>

  <table class="table table-hover">
    <thead><tr><th colspan="2"></th></tr></thead>
    <tbody>
    <tr><td>Описание</td><td><?= $model->description ?></td></tr>
    <tr><td>Категория</td><td><?php echo empty($model->category_id) ? '-' : \common\models\Category::findOne($model->category_id)->title; ?></td></tr>
    <tr><td>Цена</td><td><?= $model->price ?></td></tr>
    <tr><td>Код товара</td><td><?= $model->id ?></td></tr>
    <tr><td>Meta title</td><td><?= $model->mt ?></td></tr>
    <tr><td>Meta description</td><td><?= $model->md ?></td></tr>
    <tr><td>Meta keywords</td><td><?= $model->mk ?></td></tr>
    </tbody>
  </table>

</div>
