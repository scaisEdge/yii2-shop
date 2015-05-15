<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
?>
<div class="category-index">

  <h1><div class="row">
      <div class="col-xs-6">
        <?= Html::encode($this->title) ?>
        <?= Html::a('<i class="mdi-av-playlist-add"></i>', ['create'],
          [
            'class' => 'btn btn-add',
            'data-toggle' => 'tooltip',
            'data-placement' => 'bottom',
            'title' => 'Добавить категорию'
          ]) ?>
      </div>
      <div class="col-xs-6"><?= $this->render('_search', ['model' => $searchModel]); ?></div>
    </div></h1>

    <?= GridView::widget([
      'layout'=>"{items}\n{pager}\n{summary}",
      'dataProvider' => $dataProvider,
      'tableOptions' => ['class' => 'table table-hover',],
      'columns' => [
        [
          'attribute' => 'parent_id',
          'value' => function ($model) {
              return empty($model->parent_id) ? '-' : $model->parent->title;
          },
        ],
        'title',
        [
          'class' => 'yii\grid\ActionColumn',
          'template' => '{create} {update} {delete}',
          'buttons' => [
            'create' => function ($url, $model, $key) {
               return Html::a('<span class="update mdi-content-add" aria-hidden="true"></span>', $url, [
                 'class' => 'btn-action',
                 'data-toggle' => 'tooltip',
                 'data-placement' => 'bottom',
                 'title' => 'Добавить',
               ]);
            }
          ],
        ],
      ],
    ]); ?>

</div>
