<?php namespace backend\controllers;

use Yii;
use common\models\Category;
use backend\models\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class CategoryController extends Controller {

  public function behaviors() {
    return [
//      'access' => [
//        'class' => AccessControl::className(),
//        'rules' => [
//          [
//            'actions' => ['login', 'error'],
//            'allow' => true,
//          ],
//          [
//            'actions' => ['logout', 'index'],
//            'allow' => true,
//            'roles' => ['@'],
//          ],
//          [
//            'actions' => ['upload', 'index'],
//            'allow' => true,
//            'roles' => ['@'],
//          ],
//        ],
//      ],
      'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
          'delete' => ['post'],
        ],
      ],
    ];
  }

  public function actionIndex() {
    $searchModel = new CategorySearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
    ]);
  }

  public function actionView($id) {
    return $this->render('view', [
      'model' => $this->findModel($id),
    ]);
  }

  public function actionCreate($id = null) {
    $categories = Category::find()->all();
    $model = new Category();
    $model->parent_id = $id;
    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['index']);
    } else {
      return $this->render('create', [
        'model' => $model,
        'categories' => $categories,
      ]);
    }
  }

  public function actionUpdate($id) {
    $categories = Category::find()->all();
    $model = $this->findModel($id);
    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['index']);
    } else {
      return $this->render('update', [
        'model' => $model,
        'categories' => $categories,
      ]);
    }
  }

  public function actionDelete($id) {
    $this->findModel($id)->delete();
    return $this->redirect(['index']);
  }

  protected function findModel($id) {
    if (($model = Category::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }

}
