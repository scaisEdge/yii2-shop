<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;

class SiteController extends Controller {

    public function behaviors() {
      return [
        'verbs' => [
          'class' => VerbFilter::className(),
          'actions' => [
            'logout' => ['post'],
          ],
        ],
      ];
    }

    public function actions() {
      return [
        'error' => [
          'class' => 'yii\web\ErrorAction',
        ],
      ];
    }

  public function actionIndex() {
    return $this->render('index');
  }
}
