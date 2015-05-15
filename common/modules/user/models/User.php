<?php
namespace common\modules\user\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\rbac\DbManager;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface {

  const STATUS_DELETED = 0;
  const STATUS_ACTIVE = 10;

  const ROLE_USER = 'user';
  const ROLE_MODER = 'moder';
  const ROLE_MANAGER = 'manager';
  const ROLE_ADMIN = 'admin';

  public $new_password;
  public $repeat_password;


  public static function tableName() {return '{{%user}}';}

  public function behaviors() {
    return [
      TimestampBehavior::className(),
    ];
  }

  public function rules() {
    return [
      ['status', 'default', 'value' => self::STATUS_ACTIVE],
      ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
      [['avatar',], 'file', 'skipOnEmpty' => true, 'maxFiles' => 1],
      [['role',], 'string'],
      ['new_password', 'string', 'min' => 6],
      ['repeat_password', 'compare', 'compareAttribute'=>'new_password', 'message'=>"Passwords don't match"],
    ];
  }

  public static function findIdentity($id) {
    return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
  }
  public static function findIdentityByAccessToken($token, $type = null) {
    throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
  }
  public static function findByUsername($username) {
    return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
  }

  public static function findByPasswordResetToken($token) {
    if (!static::isPasswordResetTokenValid($token)) {return null;}
    return static::findOne([
      'password_reset_token' => $token,
      'status' => self::STATUS_ACTIVE,
    ]);
  }
  public static function isPasswordResetTokenValid($token) {
    if (empty($token)) {return false;}
    $expire = Yii::$app->params['user.passwordResetTokenExpire'];
    $parts = explode('_', $token);
    $timestamp = (int) end($parts);
    return $timestamp + $expire >= time();
  }
  public function generatePasswordResetToken() {
    $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
  }
  public function removePasswordResetToken() {
    $this->password_reset_token = null;
  }

  public function getId() {
    return $this->getPrimaryKey();
  }
  public function getAuthKey() {
    return $this->auth_key;
  }
  public function getAvatar() {
    return $this->avatar;
  }

  public function setPassword($password) {
    $this->password_hash = Yii::$app->security->generatePasswordHash($password);
  }
  public function updatePassword($new_password) {
    $this->password_hash = Yii::$app->security->generatePasswordHash($new_password);
  }

  public function validatePassword($password) {
    return Yii::$app->security->validatePassword($password, $this->password_hash);
  }

  public function generateAuthKey() {
    $this->auth_key = Yii::$app->security->generateRandomString();
  }
  public function validateAuthKey($authKey) {
    return $this->getAuthKey() === $authKey;
  }

  public function afterSave($insert, $changedAttributes) {

    // установка роли пользователя
    $auth = new DbManager;
    $name = $this->role ? $this->role : self::ROLE_USER;
    $role = $auth->getRole($name);
    if (!$insert) {
      $auth->revokeAll($this->id);
    }
    $auth->assign($role, $this->id);
  }

}
