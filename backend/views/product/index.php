<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Продукты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

  <h1><div class="row">
      <div class="col-xs-6">
        <?= Html::encode($this->title) ?>
        <?= Html::a('<i class="mdi-av-playlist-add"></i>', ['create'],
          [
            'class' => 'btn btn-add',
            'data-toggle' => 'tooltip',
            'data-placement' => 'bottom',
            'title' => 'Добавить продукт'
          ]) ?>
      </div>
      <div class="col-xs-6"><?= $this->render('_search', ['model' => $searchModel]); ?></div>
    </div></h1>
    <style>
      th:first-child, th:nth-child(3), th:nth-child(4), th:nth-child(5),
      td:first-child, td:nth-child(3), td:nth-child(4), td:nth-child(5) {text-align: center}
    </style>
    <?= GridView::widget([
      'layout'=>"{items}\n{pager}\n{summary}",
      'dataProvider' => $dataProvider,
      'tableOptions' => ['class' => 'table table-hover',],
      'columns' => [
        'id',
        'title',
//        'description:ntext',
        [
          'attribute' => 'category_id',
          'value' => function ($model) {
            return empty($model->category_id) ? '-' : $model->category->title;
          },
        ],
        'price',
        [
          'class' => 'yii\grid\ActionColumn',
          'template' => '{view} {update} {images} {delete}',
          'buttons' => [
            'images' => function ($url, $model, $key) {
               return Html::a('<span class="image mdi-image-camera-alt" aria-label="Image"></span>',
                 Url::to(['image/index', 'id' => $model->id]),[
                   'class' => 'btn-action',
                   'data-toggle' => 'tooltip',
                   'data-placement' => 'bottom',
                   'title' => 'Изображения',
                 ]);
            }
          ],
        ],
      ],
    ]); ?>

</div>
