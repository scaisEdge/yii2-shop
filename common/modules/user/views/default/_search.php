<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model @user\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search col-xs-5 pull-right">

  <?php $form = ActiveForm::begin([
      'action' => ['index'],
      'method' => 'get',
  ]); ?>

  <?= $form->field($model, 'keyword', [
    'template' => '<div class="input-group">{input}<span class="input-group-btn">'.
      Html::submitButton('Поиск', ['class' => 'btn btn-default']).'</span></div>',
  ])->textInput(array('placeholder' => '')); ?>

<!--  --><?//= $form->field($model, 'keyword')->label('Поиск') ?>
<!--  <div class="form-group">-->
<!--    --><?//= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
<!--    --><?////= Html::a('Сброс', ['/user/default'], ['class' => 'btn btn-default']) ?>
<!--  </div>-->

  <?php ActiveForm::end(); ?>

</div>
