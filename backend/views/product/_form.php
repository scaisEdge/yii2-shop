<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

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
      <tr><td>Наименование</td><td><?= $form->field($model, 'title')->textInput(['maxlength' => 255])->label(false) ?></td></tr>
      <tr><td>Описание</td><td><?= $form->field($model, 'description')->textarea(['rows' => 6])->label(false) ?></td></tr>
      <tr><td>Категория</td><td><?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map($categories, 'id', 'title'), ['prompt' => 'Select category'])->label(false) ?></td></tr>
      <tr><td>Цена</td><td><?= $form->field($model, 'price')->textInput(['maxlength' => 19]) ?></td></tr>
      <tr><td>Meta title</td><td><?= $form->field($model, 'mt')->textInput()->label(false) ?></td></tr>
      <tr><td>Meta description</td><td><?= $form->field($model, 'md')->textInput()->label(false) ?></td></tr>
      <tr><td>Meta keywords</td><td><?= $form->field($model, 'mk')->textInput()->label(false) ?></td></tr>
      </tbody>
    </table>

  <?php ActiveForm::end(); ?>

</div>
