<?php

namespace common\modules\user\controllers;

use common\modules\user\models\LoginForm;
use common\modules\user\models\PasswordResetRequestForm;
use common\modules\user\models\ResetPasswordForm;
use common\modules\user\models\SignupForm;
use common\modules\user\models\User;
use common\modules\user\models\UserSearch;
use Yii;
use yii\base\InvalidParamException;
use yii\data\Sort;
use yii\filters\AccessControl;
//use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class DefaultController extends Controller {

  public function behaviors() {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'rules' => [
          ['actions' => ['create','login', 'signup', 'index', 'error', 'profile', 'update',], 'allow' => true,],
          ['actions' => ['logout', 'index',],'allow' => true,'roles' => ['@'],],
          ['actions' => ['create','delete', ],'allow' => true,'roles' => ['supersu'],],
        ],
      ],
    ];
  }

  public function actions() {
    return [
      'error' => [
        'class' => 'yii\web\ErrorAction',
      ],
      'captcha' => [
        'class' => 'yii\captcha\CaptchaAction',
        'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
      ],
    ];
  }

  public function actionIndex() {
    $searchModel = new UserSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    $sort = new Sort([
      'attributes' => [
        'id',
        'username',
        'created_at',
        'updated_at',
      ],
    ]);

//    $models = Article::find()
//      ->where(['status' => 1])
//      ->orderBy($sort->orders)
//      ->all();
//    ]);
    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
      'sort' => $sort,
    ]);
  }

  public function actionProfile($id) {
    return $this->render('profile', [
      'model' => $this->findModel($id),
    ]);
  }

  public function actionCreate() {
    $model = new SignupForm();
    if ($model->load(Yii::$app->request->post())) {
      if ($user = $model->signup()) {
        return $this->goHome();
      }
    }
    return $this->render('create', [
      'model' => $model,
    ]);
  }

  public function actionUpdate($id) {
    $model = $this->findModel($id);
    if ($model->id == Yii::$app->user->identity->id || Yii::$app->user->can('supersu')) {
      $x = $model->getAvatar();
      if ($model->load(Yii::$app->request->post())) {

        $files = UploadedFile::getInstances($model, 'avatar');
        $avatarArr = [];
        if (!empty($files)) {
          if ($model->avatar && $model->validate()) {
            foreach ($files as $avatar) {
              $link = "../../common/modules/user/uploads/user-avatar/";
              $filename = $model->id . '.' . $avatar->extension;
              $avatar->saveAs($link . $filename);
              $link = "/common/modules/user/uploads/user-avatar/";
              $avatarArr[] = $link . $filename;
            }
          }
          $model->avatar = Json::encode($avatarArr);
        } else {
          $model->avatar = $x;
        }
        if (!empty($new_password)) {$model->updatePassword($model->new_password);}
        $model->save(false);
        return $this->redirect(['profile', 'id' => $model->id]);
      } else {
        return $this->render('update', [
          'model' => $model,
        ]);
      }
    } else {
      //rewrite as url
      return  $this->redirect('index.php?r=user/default');
    }

  }

  public function actionDelete($id) {
    $this->findModel($id)->delete();
    return $this->redirect(['index']);
  }

  public function actionSignup() {
    $model = new SignupForm();

    if ($model->load(Yii::$app->request->post())) {
      if ($user = $model->signup()) {
        if (Yii::$app->getUser()->login($user)) {
          return $this->goHome();
        }
      }
    }
    return $this->render('signup', [
      'model' => $model,
    ]);
  }

  public function actionLogin() {
    if (!\Yii::$app->user->isGuest) {
      return $this->goHome();
    }
    $model = new LoginForm();
    if ($model->load(Yii::$app->request->post()) && $model->login()) {
      return $this->goBack();
    } else {
      return $this->render('login', [
        'model' => $model,
      ]);
    }
  }

  public function actionLogout() {
    Yii::$app->user->logout();
    return $this->goHome();
  }

  public function actionRequestPasswordReset() {
    $model = new PasswordResetRequestForm();
    if ($model->load(Yii::$app->request->post()) && $model->validate()) {
      if ($model->sendEmail()) {
        Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');
        return $this->goHome();
      } else {
        Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
      }
    }
    return $this->render('requestPasswordResetToken', [
      'model' => $model,
    ]);
  }

  public function actionResetPassword($token) {
    try {
      $model = new ResetPasswordForm($token);
    } catch (InvalidParamException $e) {
      throw new BadRequestHttpException($e->getMessage());
    }
    if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
      Yii::$app->getSession()->setFlash('success', 'New password was saved.');
      return $this->goHome();
    }
    return $this->render('resetPassword', [
      'model' => $model,
    ]);
  }

  protected function findModel($id) {
    if (($model = User::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }

}
