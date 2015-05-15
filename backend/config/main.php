<?php $params = array_merge(
  require(__DIR__ . '/../../common/config/params.php'),
  require(__DIR__ . '/../../common/config/params-local.php'),
  require(__DIR__ . '/params.php'),
  require(__DIR__ . '/params-local.php')
); return [
  'id' => 'app-backend',
  'basePath' => dirname(__DIR__),
  'controllerNamespace' => 'backend\controllers',
  'bootstrap' => ['log'],
  'modules' => [],
  'defaultRoute' => 'site/index',
  'components' => [
    'user' => [
      'identityClass' => 'common\modules\user\models\User',
      'enableAutoLogin' => true,
    ],
    'session' => [
      'name' => 'BACKENDID',
      'savePath' => __DIR__ . '\..\web\tmp',
    ],
    'log' => [
      'traceLevel' => YII_DEBUG ? 3 : 0,
      'targets' => [
        [
          'class' => 'yii\log\FileTarget',
          'levels' => ['error', 'warning'],
        ],
      ],
    ],
    'errorHandler' => [
      'errorAction' => 'site/error',
    ],
  ],
  'params' => $params,
];
