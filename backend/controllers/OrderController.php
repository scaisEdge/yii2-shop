<?php

namespace backend\controllers;

use common\models\OrderItem;
use common\models\Product;
use Yii;
use common\models\Order;
use backend\models\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class OrderController extends Controller {

  public function behaviors() {
    return [
      'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
          'delete' => ['post'],
        ],
      ],
    ];
  }

  public function actionIndex() {
    $searchModel = new OrderSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    $dataProvider->pagination->pageSize=10;
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

  public function actionCreate() {
    $model = new Order();
    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
    } else {
      return $this->render('create', [
        'model' => $model,
      ]);
    }
  }

  public function actionUpdate($id) {
    $model = $this->findModel($id);
    if ($model->load(Yii::$app->request->post()) && $model->save()) {

      return $this->redirect(['view', 'id' => $model->id]);
    } else {
      return $this->render('update', [
        'model' => $model,
      ]);
    }
  }

  public function actionDelete($id) {
    $this->findModel($id)->delete();
    return $this->redirect(['index']);
  }

  public function actionDeleteItem($id) {
    OrderItem::findOne($id)->delete();
//    \Yii::$app->session->addFlash('success', 'Продукт успешно удален из этого заказа.');
  }

  public function actionAddItem($id) {
    $model = $this->$model;
    $product = Product::findOne($id);
    $orderItem = new OrderItem();
    $orderItem->order_id = $model->id;
    $orderItem->title = $product->title;
    $orderItem->price = $product->getPrice();
    $orderItem->product_id = $product->id;
    $orderItem->save();
    return $this->redirect(['index']);
  }

  protected function findModel($id) {
    if (($model = Order::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }

}
