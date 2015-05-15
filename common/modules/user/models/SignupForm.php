<?php
namespace common\modules\user\models;

use common\modules\user\models\User;
use yii\base\Model;
use Yii;
use yii\helpers\Json;

class SignupForm extends Model {

  public $username;
  public $email;
  public $password;
  public $role;
  public $repeat_password;

  public function rules() {
    return [
      ['username', 'filter', 'filter' => 'trim'],
      ['username', 'required'],
      ['username', 'unique', 'targetClass' => '\common\modules\user\models\User', 'message' => 'This username has already been taken.'],
      ['username', 'string', 'min' => 2, 'max' => 255],

      ['email', 'filter', 'filter' => 'trim'],
      ['email', 'required'],
      ['email', 'email'],
      ['email', 'unique', 'targetClass' => '\common\modules\user\models\User', 'message' => 'This email address has already been taken.'],

      ['password', 'required'],
      ['password', 'string', 'min' => 6],
      ['repeat_password', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match"],
    ];
  }

  /** @return User|null the saved model or null if saving fails */
  public function signup() {
    if ($this->validate()) {
      $user = new User();
      $user->username = $this->username;
      $user->email = $this->email;
      $avatar[] = "/common/modules/user/uploads/user-avatar/0.png";
      $user->avatar = Json::encode($avatar);
//      $user->role = 'user';
      $user->setPassword($this->password);
      $user->generateAuthKey();
      if ($user->save()) {
        return $user;
      }
    }
    return null;
  }
}
