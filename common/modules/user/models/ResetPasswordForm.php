<?php
namespace common\modules\user\models;

use common\modules\user\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;

class ResetPasswordForm extends Model {

  public $password;

  /** @var \common\modules\user\models\User */
  private $_user;

  public function __construct($token, $config = []) {
    if (empty($token) || !is_string($token)) {
      throw new InvalidParamException('Password reset token cannot be blank.');
    }
    $this->_user = User::findByPasswordResetToken($token);
    if (!$this->_user) {
      throw new InvalidParamException('Wrong password reset token.');
    }
    parent::__construct($config);
  }

  public function rules() {
    return [
      ['password', 'required'],
      ['password', 'string', 'min' => 6],
    ];
  }

  public function resetPassword() {
    $user = $this->_user;
    $user->password = $this->password;
    $user->removePasswordResetToken();
    return $user->save();
  }

}
