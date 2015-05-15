<?php namespace backend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle {

  public $basePath = '@webroot';
  public $baseUrl = '@web';
  public $css = [
    'css/bootstrap.css',
    'css/fileinput.css',
    'css/jquery.flex-images.css',
    'font/mdi/mdi.min.css',
    'css/style.css',
  ];
  public $js = [
    'js/jquery-1.11.1.min.js',
    'js/bootstrap.min.js',
    'js/fileinput.js',
    'js/fileinput_locale_ru.js',
    'js/jquery.flex-images.js',
    'js/custom.js',
  ];
  public $depends = [
    'yii\web\YiiAsset',
    'yii\web\JqueryAsset',
    'yii\bootstrap\BootstrapAsset',
    'yii\bootstrap\BootstrapPluginAsset'
  ];
}
