<?php return [
  'name'=>'dev.loc',

  'language' => 'ru-RU',
  'charset' => 'UTF-8',
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

    'urlManager' => [
      'enablePrettyUrl' => true,
      'showScriptName' => false,
      'rules' => [
        '<controller:\w+>/<id:\d+>' => '<controller>/view',
        '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
        '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
        '<module>/<controller>/<action>/<id:\d+>' => '<module>/<controller>/<action>',
//        '<alias:login|logout|signup>' => 'user/default/<alias>',
      ],
    ],

  ],

];
