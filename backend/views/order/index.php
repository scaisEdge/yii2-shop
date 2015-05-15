<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

  <h1><div class="row">
    <div class="col-xs-6">
      <?= Html::encode($this->title) ?>
      <?= Html::a('<i class="mdi-av-playlist-add"></i>', ['create'],
        [
          'class' => 'btn btn-add',
          'data-toggle' => 'tooltip',
          'data-placement' => 'bottom',
          'title' => 'Добавить заказ'
        ]) ?>
    </div>
    <div class="col-xs-6"><?= $this->render('_search', ['model' => $searchModel]); ?></div>
  </div></h1>

  <style>
    th:first-child, th:nth-child(3),  th:nth-child(4),
    td:first-child, td:nth-child(3),  td:nth-child(4) {text-align: center}
  </style>

  <?= GridView::widget([
    'layout'=>"{items}\n{pager}\n{summary}",
    'dataProvider' => $dataProvider,
    'tableOptions' => ['class' => 'table table-hover',],
    'columns' => [
      'id',
      'created_at:datetime',
//      'updated_at:datetime',
//      'phone',
//      'email:email',
//      'notes:ntext',
      'status',
      ['class' => 'yii\grid\ActionColumn'],
    ],
  ]); ?>

</div>
