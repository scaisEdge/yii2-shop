<?php

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$asset = AppAsset::register($this);

$this->beginPage() ?><!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>"><head>

  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>

  <link href='http://fonts.googleapis.com/css?family=Open+Sans:700,600,400&subset=cyrillic,latin' rel='stylesheet' type='text/css'>
  <?php $this->head() ?>
</head><body>
<?php $this->beginBody() ?>
<div id="ds_wrap" class="clearfix">

  <div id="ds_content">
    <header>
      <a class="ds_logo" href="#"></a>
      <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
      ]) ?>
    </header>
    <div class="container">
      <?= $content ?>
    </div>
  </div>

  <div id="ds_aside">
    <header>
      <a class="ds_website" href="http://dev.loc/frontend/web/" data-toggle="tooltip" data-placement="bottom" title="dev.loc" target="_blank"><i class="mdi-action-launch"></i></a>
      <div class="dropdown" style="display: inline-block">
        <a id="dLabel"
           class="ds_user"
           data-toggle="dropdown"
           aria-haspopup="true"
           role="button"
           aria-expanded="false">
          <i class="mdi-action-assignment-ind"></i>
        </a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
          ...
        </ul>
      </div>
      <div class="dropdown" style="display: inline-block">
        <a id="dLabel2"
           class="ds_user"
           data-toggle="dropdown"
           aria-haspopup="true"
           role="button"
           aria-expanded="false">
          <i class="mdi-notification-sms-failed"></i>
        </a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel2">
          ...
        </ul>
      </div>
<!--      <a class="ds_mess" href="#" data-toggle="tooltip" data-placement="bottom" title="Сообщения"><i class="mdi-communication-forum"></i></a>-->
    </header>
    <?php echo \yii\widgets\Menu::widget([
      'options' => [
        'id' => 'ds_nav'
      ],
      'activateParents'=>false,
      'items' => [
        [
          'label'=>'Главная',
          'url'=>['/site/index'],
          'template' => '<a href="{url}"><i class="mdi-av-equalizer"></i>{label} <span class="ds_counter">44</span></a>',
        ],
        [
          'label'=>'Магазин',
          'url'=>['#'],
          'template' => '<a class="ds_hassubmenu"><i class="mdi-action-shopping-cart"></i>{label}</a>',
          'items' => [
            [
              'label'=>'Заказы',
              'url'=>['/order/index'],
              'template' => '<a href="{url}">{label} <span class="ds_counter">'.\common\models\Order::find()->count().'</span></a>',
              'active'=>\Yii::$app->controller->id == 'order'
            ],
            [
              'label'=>'Продукты',
              'url'=>['/product/index'],
              'template' => '<a href="{url}">{label} <span class="ds_counter">'.\common\models\Product::find()->count().'</span></a>',
              'active'=>\Yii::$app->controller->id == 'product' || \Yii::$app->controller->id == 'image'
            ],
            [
              'label'=>'Категории',
              'url'=>['/category/index'],
              'template' => '<a href="{url}">{label}</a>',
              'active'=>\Yii::$app->controller->id == 'category'
            ],
          ]
        ],
        [
          'label'=>'Пользователи',
          'url'=>['/user/default/index'],
          'template' => '<a href="{url}"><i class="mdi-social-group"></i>{label}</a>',
          'active'=>\Yii::$app->controller->id == 'default'
        ],
        [
          'label'=>'Настройки',
          'url'=>['#'],
          'template' => '<a href="{url}"><i class="mdi-action-settings"></i>{label}</a>',
        ],

      ],
    ]);?>
  </div>

</div>

<?php $this->endBody() ?>
</body></html>
<?php $this->endPage() ?>