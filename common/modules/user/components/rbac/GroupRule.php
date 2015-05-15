<?php

namespace common\modules\user\components\rbac;

use Yii;
use yii\rbac\Rule;

class GroupRule extends Rule {

  public $name = 'group';

  public function execute($user, $item, $params) {
    if (!Yii::$app->user->isGuest) {
      $role = Yii::$app->user->identity->role;

      if ($item->name === 'supersu') {
        return $role === $item->name;
      } elseif ($item->name === 'admin') {
        return $role === $item->name || $role === 'supersu';
      } elseif ($item->name === 'manager ') {
        return $role === $item->name || $role === 'supersu' || $role === 'admin';
      } elseif ($item->name === 'moder') {
        return $role === $item->name || $role === 'supersu' || $role === 'admin' || $role === 'manager';
      } elseif ($item->name === 'user') {
        return $role === $item->name || $role === 'supersu' || $role === 'admin' || $role === 'manager' || $role === 'moder';
      }
    }
    return false;
  }
}