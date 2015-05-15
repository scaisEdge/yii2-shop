<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $categories common\models\Category[] */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

  <?php $form = ActiveForm::begin(); ?>
  <h1>
    <?= Html::encode($this->title) ?>
    <?= Html::submitButton($model->isNewRecord ? '<i class="mdi-action-done"></i>' : '<i class="mdi-action-done"></i>',
      [
        'class' => $model->isNewRecord ? 'btn btn-save pull-right' : 'btn btn-save pull-right',
        'data-toggle'=>'tooltip' ,
        'data-placement'=>'bottom',
        'title'=> $model->isNewRecord ? 'Добавить' : 'Сохранить',
      ]) ?>
  </h1>
  <table class="table table-hover">
    <thead><tr><th colspan="2"></th></tr></thead>
    <tbody>
    <tr><td>Родительская</td><td> <?= $form->field($model, 'parent_id')->dropDownList(ArrayHelper::map($categories, 'id', 'title'), ['prompt' => 'Root'])->label(false) ?></td></tr>
    <tr><td>Название</td><td><?= $form->field($model, 'title')->textInput(['maxlength' => 255])->label(false) ?></td></tr>

    </tbody>
  </table>

  <?php ActiveForm::end(); ?>

</div>
