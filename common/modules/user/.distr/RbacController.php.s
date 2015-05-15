<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\modules\user\components\rbac\GroupRule;
use yii\rbac\DbManager;

class RbacController extends Controller {
  /**
   * Initial RBAC action
   * @param integer $id Superadmin ID
   *
   * If (Yii::$app->user->can('admin')) { … }
   *
   */
  public function actionInit($id = null) {

    $auth = new DbManager;
    $auth->init();

    $auth->removeAll();

    $groupRule = new GroupRule();

    $auth->add($groupRule);

    $user = $auth->createRole('user');
    $user->description = 'User';
    $user->ruleName = $groupRule->name;
    $auth->add($user);

    $moder = $auth->createRole('moder');
    $moder->description = 'Moder ';
    $moder ->ruleName = $groupRule->name;
    $auth->add($moder);

    $manager = $auth->createRole('manager');
    $manager ->description = 'manager ';
    $manager ->ruleName = $groupRule->name;
    $auth->add($manager);

    $admin = $auth->createRole('admin');
    $admin->description = 'Admin';
    $admin->ruleName = $groupRule->name;
    $auth->add($admin);

    $supersu = $auth->createRole('supersu');
    $supersu->description = 'SuperSu';
    $supersu->ruleName = $groupRule->name;
    $auth->add($supersu);

    if ($id !== null) {
      $auth->assign($supersu, $id);
    }
  }
}