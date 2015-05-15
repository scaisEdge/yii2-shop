<?php

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \common\modules\user\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view col-xs-12">
  <div class="row">

    <!--  <h1 style="margin-bottom: 60px;">-->
    <!--    --><?//= Html::encode($this->title) ?>
    <!--  </h1>-->

    <div class="col-xs-3" style="border-right: 5px solid #eee">
      <?php if ($model->id == Yii::$app->user->identity->id || Yii::$app->user->can('supersu')) { ?>
        <?= Html::a('Редактировать профиль', ['update', 'id' => $model->id], ['class' => '']).'<br>' ?>
      <?php } ?>

      <?php if ($model->id == Yii::$app->user->identity->id) { ?>
        <?php //if ($model->id == Yii::$app->user->identity->id || Yii::$app->user->can('supersu')) { ?>
        <?= Html::a('Мои сообщения', ['/user/message'], ['class' => '']) ?>
      <?php } else { ?>
        <?= Html::a('Написать сообщение', ['update', 'id' => $model->id], ['class' => '']) ?>
      <?php } ?>
    </div>

    <div class="col-xs-9">
      <div style="width:230px; float:left;">
        <?php $arr = Json::decode($model->avatar); foreach ($arr as $path) {echo '<img width="200" src="'.$path.'">';} ?>
      </div>

      <div style="width:calc(100% - 230px); float:left;">
        <h2><?= $model->username ?></h2>
        <?= $model->role ?><br>
        <a href=""><?= $model->email ?></a>
      </div>
    </div>

  </div>
</div>
