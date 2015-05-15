<?php
namespace common\modules\user\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model {

  public $username;
  public $password;
  public $rememberMe = true;

  private $_user = false;

  public function rules() {
    return [
      [['username', 'password'], 'required'],
      ['rememberMe', 'boolean'],
      ['password', 'validatePassword'],
    ];
  }

  public function validatePassword($attribute, $params) {
    if (!$this->hasErrors()) {
      $user = $this->getUser();
      if (!$user || !$user->validatePassword($this->password)) {
        $this->addError($attribute, 'Incorrect username or password.');
      }
    }
  }

  public function login() {
    if ($this->validate()) {
      return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
    } else {
      return false;
    }
  }

  /** @return User|null */
  public function getUser() {
    if ($this->_user === false) {

//      able to login using username only
//      $this->_user = User::findByUsername($this->username);

//      able to login using username or email
      $this->_user = User::find()
        ->andWhere(['or', ['username' => $this->username],
          ['email' => $this->username]])
        ->one();

//      Lock login for one role
//      if (!Yii::$app->user->can('supersu', ['user' => $this->_user])) {
//        $this->_user = null;
//      }
    }
    return $this->_user;
  }

}
