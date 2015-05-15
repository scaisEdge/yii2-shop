<?php

use common\modules\user\components\Setup;
use common\modules\user\models\User;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\user\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Полученные';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-index col-xs-12">

  <h1 style="margin-bottom: 30px;">
    <?= Html::encode($this->title) ?>
  </h1>

  <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <div style="width:230px;float:left;">
    <?= Html::a('Написать', ['create'], ['class' => '']) ?><br>
    <?= Html::a('Полученные', ['index'], ['class' => '']) ?><br>
    <?= Html::a('Отправленные', ['sent'], ['class' => '']) ?><br>
  </div>

  <div style="width:calc(100% - 230px); float:left;">
    <?php foreach ($dataProvider->models as $model) {
      if ($model->to == Yii::$app->user->identity->id) {
        echo Html::a('
          <div class="col-xs-2">От кого:</div>
          <div class="col-xs-2" style="font-weight: bold">'.User::findIdentity($model->from)->username.'</div>
          <div class="col-xs-6">'.$model->message.'</div>
          <div class="col-xs-2">'.Setup::convert($model->created_at, 'date').'<br></div>
        ', ['view','id' => $model->id], ['class' => 'row','style'=>'display:block;']) ;
      }
    } ?>
  </div>

</div>
