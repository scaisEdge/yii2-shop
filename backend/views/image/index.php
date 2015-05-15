<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $form backend\models\MultipleUploadForm */

$this->title = 'Изображения продукта' ;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="image-index">
  <?php \yii\widgets\Pjax::begin(['timeout' => 10000,'clientOptions' => ['container' => 'pjax-container']]); ?>
    <h1 style="margin-bottom: 30px"><?= Html::encode($this->title) ?></h1>
    <?php if ($searchModel->product_id) : ?>
      <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
      <?= $form->field($uploadForm, 'files[]')->fileInput([
        'multiple' => true ,
        'class'=>'file',
      ])->label(false) ?>
      <?php ActiveForm::end() ?>
    <?php endif ?>


  <div class="flex-images">
    <?php foreach ( $dataProvider->models as $image ) {
      if ($image->product_id == $searchModel->product_id) {?>

      <?= /** @var $model common\models\Image */
      Html::a(Html::img($image->getUrl()).'<div class="deleteImg"><i class="mdi-action-delete"></i></div>', ['delete', 'id' => $image->id], [
        'class' => 'product-image item',
        'title'=>'Удалить',
        'data-w'=>'200',
        'data-h'=>'200',
        'data' => [
          'confirm' => 'Вы уверены что хотите удалить это изображение?',
          'method' => 'post',
        ],
      ]) ?>

    <?php } } ?>

  </div>
  <?php \yii\widgets\Pjax::end(); ?>
</div>
