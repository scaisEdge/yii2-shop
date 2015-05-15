<?php return [

  'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',

  'modules' => [
    'user' => [
      'class' => 'common\modules\user\Module',
    ],
  ],

  'components' => [

    'cache' => [
      'class' => 'yii\caching\FileCache',
    ],

    'authManager' => [
      'class' => 'yii\rbac\DbManager',
      'defaultRoles' => [
        'user',
        'moder',
        'manager',
        'admin',
        'supersu'
      ],
    ],

  ],

];
