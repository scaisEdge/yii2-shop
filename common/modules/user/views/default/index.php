<?php

use common\components\SetDTFormat;
use yii\helpers\Html;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $searchModel @user\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
  .user-default-index-table {width: 100%;}
  .user-default-index-table thead tr {border-bottom: 5px solid #d2d2d2;}
  .user-default-index-table thead tr th {padding-bottom:15px;}
  .user-default-index-table tbody tr td {padding-top: 10px; padding-bottom: 10px;}
  .user-default-index-table tbody tr {border-bottom: 1px solid #d2d2d2}
  .user-default-index-table thead tr th:first-child,
  .user-default-index-table tbody tr td:first-child {text-align: center;padding-left: 15px;width:40px;}
  .user-default-index-table tbody tr td:nth-child(2) {width: 50px;}
  .user-default-index-table thead tr th:nth-child(3),
  .user-default-index-table tbody tr td:nth-child(3) {padding-left: 10px;}
  .user-default-index-table tbody tr td:nth-child(3) a {font-size: 140%;}
  .user-default-index-table tbody tr td:nth-child(3) span {position: relative;top: -5px; font-size: 90%;}
  span.status-active {
    background: #5CB85C;
    border-radius: 10px;
    width: 29px;
    height: 20px;
    display: block;
    position: relative;
    top: -10px;
    left: 8px;
    color: #FFF;
  }
</style>

<div class="user-index">

  <?php \yii\widgets\Pjax::begin(['timeout' => 10000,'clientOptions' => ['container' => 'pjax-container']]); ?>

    <h1 class="clearfix">
      <span><?= Html::encode($this->title) ?></span>
      <?= Html::a('<i class="mdi-av-playlist-add"></i>', ['create'],
        [
          'class' => 'btn btn-add',
          'data-toggle' => 'tooltip',
          'data-placement' => 'bottom',
          'title' => 'Добавить пользователя'
        ]) ?>
      <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    </h1>

    <div id="ds44_block">
      <table class="user-default-index-table">
        <thead>
        <tr style="">
          <th style="padding-left: 30px;"><?=  $sort->link('id') ?></th>
          <th></th>
          <th><?=  $sort->link('username') ?></th>
          <th>Email</th>
          <?php If (Yii::$app->user->can('supersu')) { ?>
            <th style="text-align:center;"><?= $sort->link('created_at') ?></th>
            <th></th>
            <th></th>
            <th></th>
          <?php } ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($dataProvider->models as $model) {
          If (Yii::$app->user->can('supersu')) {
            $status = $model->status;
            if ($status == 10) {$showstatus = '<span class="status-active">'.$model->id.'</span>';}
          }
          $arr = Json::decode($model->avatar);
          foreach ($arr as $path) {
            $avatar = 'width:50px; height:50px; display: block; overflow: hidden; border-radius: 100%; box-shadow: inset 2px 4px 5px rgba(0,0,0,.30);border: 2px solid; background:url('.$path.');background-size: cover;';
          }
          ?>
          <tr>
            <td><?= $showstatus ?></td>
            <td><?= Html::a( '' , ['profile', 'id' => $model->id], ['style' => $avatar]) ?></td>
            <td><?= Html::a( $model->username , ['profile', 'id' => $model->id]).'<br><span>'.$model->role.'</span>' ?></td>
            <td><?= Html::a( $model->email , ['profile', 'id' => $model->id]) ?></td>
            <?php If (Yii::$app->user->can('supersu')) {
              echo '<td style="text-align:center;">'.SetDTFormat::convert($model->created_at, 'datetime').'</td>';
              echo '<td style="text-align:center;">'.Html::a( '<i class="mdi-content-create"></i>', ['update', 'id' => $model->id]).' ';
              if ($model->id == 1) { echo '</td>'; } else {
                echo Html::a( '<i class="mdi-action-delete"></i>' , ['delete', 'id' => $model->id], ['style' => 'color:red;']).'</td>';
              }
            } ?>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>

  <?php \yii\widgets\Pjax::end(); ?>
</div>
