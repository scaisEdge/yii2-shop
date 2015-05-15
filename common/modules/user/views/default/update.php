<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\user\models\User */

$this->title = 'Редактировать: ' . ' ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="user-update">

  <h1 style="padding: 0"><?= Html::encode($this->title) ?></h1>

  <div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'avatar[]')->fileInput(['multiple' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>

<!--    --><?php //If (Yii::$app->user->can('supersu')) {
//      echo $form->field($model, 'role')->dropDownList([
//        'user' => 'Пользователь',
//        'moder' => 'Модератор',
//        'manager' => 'Менеджер',
//        'admin' => 'Администратор',
//        'supersu' => 'su' ]);}
//    elseif (Yii::$app->user->can('admin')) {
//      echo $form->field($model, 'role')->dropDownList([
//        'user' => 'Пользователь',
//        'moder' => 'Модератор',
//        'manager' => 'Менеджер',
//        'admin' => 'Администратор', ]);} ?>

    <?=
    $form->field($model, 'role')->dropDownList([
      'user' => 'Пользователь',
      'moder' => 'Модератор',
      'manager' => 'Менеджер',
      'admin' => 'Администратор',
      'supersu' => 'su' ]);
    ?>

    <?= $form->field($model, 'new_password')->passwordInput() ?>
    <?= $form->field($model, 'repeat_password')->passwordInput()->label('Repeat New Password') ?>

    <div class="form-group">
      <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить',
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

  </div>

</div>
